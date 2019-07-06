<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;
use App\FacultyEdge;
use App\University;
use Illuminate\Support\Facades\Storage;
use App\UniFac;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Collection;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Edges = [];
        foreach (FacultyEdge::all()->unique('TempName') as  $Edge) {
            //Get University
            $UniId = $this->GetUniversityIdFromEdge($Edge);
            if ($UniId) {
                //Get Faculty
                $FacultyId = $this->GetFacultyIdFromEdge($Edge, University::find($UniId));
                if ($FacultyId) {
                    $Edges[] = 'Edge: ' . $Edge->TempName . ' | Faculty: ' . Faculty::find($FacultyId)->name . ' | University: ' . University::find($UniId)->name;
                    continue;
                }
                $Edges[] = 'Edge: ' . $Edge->TempName . ' | Faculty: Not Found | University: ' . University::find($UniId)->name;
            } else {
                $Edges[] = 'Edge: ' . $Edge->TempName . ' | Faculty: Not Found | University: Not Found';
            }
        }
        sort($Edges);
        dd($Edges);
    }
    function GetUniversityIdFromEdge($edge) {
        //Let's try to figure out what university it is
        $EdgeName = PagesController::UnifyName($edge->TempName);
        $UniId = 0;
        //Check not Institute
        if (((\Str::contains($EdgeName, 'صناعي') || \Str::contains($EdgeName, 'فني')) && !\Str::contains($EdgeName, 'جامعة')) ||
            \Str::contains($EdgeName, 'معهد') || \Str::contains($EdgeName, 'عالي') || \Str::contains($EdgeName, 'اكاديمي')) {
            //Do Nothing but prevent checking the rest
        } elseif (\Str::contains($EdgeName, 'بور سعيد')) {
            $UniId = University::where('name', 'LIKE', '%بورسعيد%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'سادات')) {
            $UniId = University::where('name', 'LIKE', '%مدينة السادات%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'كفرشيخ')) {
            $UniId = University::where('name', 'LIKE', '%كفر الشيخ%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'قنا') || \Str::contains($EdgeName, 'الاقصر') || \Str::contains($EdgeName, 'غردقة')) {
            $UniId = University::where('name', 'LIKE', '%جنوب الوادي%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'منيه النصر')) {
            $UniId = University::where('name', 'LIKE', '%المنصورة%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'عباسية')) {
            $UniId = University::where('name', 'LIKE', '%عين شمس%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'جيزة')) {
            $UniId = University::where('name', 'LIKE', '%القاهرة%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'اشمون')) {
            $UniId = University::where('name', 'LIKE', '%المنوفية%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'مشتهر')) {
            $UniId = University::where('name', 'LIKE', '%بنها%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'اسماعيليه')) {
            $UniId = University::where('name', 'LIKE', '%قناة السويس%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'وادي') && \Str::contains($EdgeName, 'جديد')) {
            $UniId = University::where('name', 'LIKE', '%أسيوط%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'مطروح')) {
            $UniId = University::where('name', 'LIKE', '%الاسكندرية%')->first()->id;
        } elseif (\Str::contains($EdgeName, 'شبين كوم')) {
            $UniId = University::where('name', 'LIKE', '%المنوفية%')->first()->id;
        } else {
            $similars = [];
            foreach (University::all() as $uni) {
                $name = PagesController::UnifyName($uni->name);
                $name = str_replace('أ', 'ا', $name); //Additional (for Assyout and Aswan)
                if ($uni->type == config('enums.university_types.GOV')) {
                    $name = str_replace('جامعه ', '', $name);      //Remove جامعة from the beginning
                }
                if (\Str::contains($EdgeName, $name) || \Str::contains($EdgeName, str_replace('ال', '', $name))) {
                    $UniId = $uni->id;
                    break;
                }
                if ($UniId == 0) {
                    //Try to figure out what it is!
                    // similar_text($EdgeName,$name,$p);
                    // $similars[$p] = $EdgeName . ' - ' . $name;
                }
            }
        }
        return $UniId;
    }

    function GetFacultyIdFromEdge($Edge,$Uni) {
        $EdgeName = str_replace('كلية ','',$Edge->TempName);
        $EdgeName = str_replace('انتساب','',$EdgeName);
        $EdgeName = str_replace('موجه','',$EdgeName);
        $EdgeName = PagesController::UnifyName($EdgeName);
        $FacId = 0;
        $Matches = [];
        foreach ($Uni->faculties as  $Fac) {
            $FacName = PagesController::UnifyName($Fac->name);
            //$FacName = str_replace(' ','%',$FacName);
            if ($FacName == 'طب الفم والاسنان') {
                if (\Str::contains($EdgeName,"اسنان")) {
                    return $Fac->id;
                } else {
                    continue;
                }
            }
            if (\Str::contains($EdgeName,$FacName . ' ')) {
                if ($FacName == 'طب') {
                    $EdgeName = $Edge->TempName;
                    if (\Str::contains($EdgeName,'بيطري') || \Str::contains($EdgeName,'اسنان') || !\Str::startsWith($EdgeName,'طب'))
                    {
                        continue;
                    }
                }
                if ($FacName == 'تربيه') {
                    $FacName = PagesController::UnifyName($Fac->name);
                    if (\Str::contains($EdgeName,'تربيه نوعيه') || \Str::contains($EdgeName,'تربيه رياضيه'))
                    {
                        continue;
                    }
                }
                return $Fac->id;
            }
        }
        return 0;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faculties.create')->with('unis',University::orderBy('name')->pluck('name','id'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        //
    }
}
