<?php

namespace App\Http\Controllers;

use App\Models\Tansik\Faculty;
use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use App\Models\Team\Member;
use App\Traits\Paginate;
use Illuminate\Http\Request;

class TansikController extends Controller
{
    use Paginate;


    public function index(Request $request)
    {
        $edges = FacultyEdge::orderBy('created_at')->where('confirmed',false)->get()->unique('TempName');
        $count = FacultyEdge::where('edit_by', auth()->user()->member->id)->distinct('TempName')->count();
        $countConfirm = FacultyEdge::where('confirmed_by', auth()->user()->member->id)->distinct('TempName')->count();
        $edges = $this->paginate($edges, config('app.pagination_max'), $request->page)->withPath(route('tansik.edges.index'));
        return view('tansik-work.index')
            ->with(compact('edges'))
            ->with(compact('countConfirm'))
            ->with(compact('count'));
    }

    public function edit(FacultyEdge $facultyEdge = null)
    {
        if (is_null($facultyEdge))
        {
            $facultyEdge = FacultyEdge::where('edit_by', null)->inRandomOrder()->limit(1)->lockForUpdate()->first();
            if(is_null($facultyEdge))
            {
                return redirect()->route('tansik.edges.index');
            }
        }
        $universities = University::where('type','governmental')->pluck('name','id');
        $faculties = Faculty::pluck('name','id');

        $count = FacultyEdge::where('edit_by',auth()->user()->member->id)->distinct('TempName')->count();
        $countConfirm = FacultyEdge::where('confirmed_by',auth()->user()->member->id)->distinct('TempName')->count();
        return view('tansik-work.edit')->with(compact('faculties'))
            ->with(compact('universities'))
            ->with(compact('count'))
            ->with(compact('countConfirm'))
            ->with('edge', $facultyEdge);
    }
    public function confirm_view(FacultyEdge $facultyEdge = null)
    {
        if (is_null($facultyEdge))
        {
            $facultyEdge = FacultyEdge::where('edit_by','!=',null)->where('edit_by', '!=', auth()->user()->member->id)->where('confirmed', false)->inRandomOrder()->limit(1)->lockForUpdate()->first();
            if(is_null($facultyEdge))
            {
                return redirect()->route('tansik.edges.index');
            }
        }
        $universities = University::where('type','governmental')->pluck('name','id');
        $faculties = Faculty::pluck('name','id');
        $count = FacultyEdge::where('edit_by',auth()->user()->member->id)->distinct('TempName')->count();
        $countConfirm = FacultyEdge::where('confirmed_by',auth()->user()->member->id)->distinct('TempName')->count();
        return view('tansik-work.confirm')->with(compact('faculties'))
            ->with(compact('universities'))
            ->with(compact('count'))
            ->with(compact('countConfirm'))
            ->with('edge', $facultyEdge);
    }

    public function update(Request $request, FacultyEdge $facultyEdge)
    {
        $request->validate([
            'name' => 'required|exists:faculty_edges,TempName',
            'is_faculty' => 'required|boolean',
            'university' => 'required_if:is_faculty,1|exists:universities,id',
            'faculty' => 'required_if:is_faculty,1|exists:faculties,id',
        ]);
        //Check it's not already edit
        if(is_null($facultyEdge->UniFac))
        {
            if ($request->is_faculty) {
                $university = University::find($request->university);
                $faculty = Faculty::find($request->faculty);

                $unifac = UniFac::where('university_id',$request->university)->where('faculty_id',$request->faculty)->first();
                if(is_null($unifac)) {
                    //Does not exist
                    $unifac = UniFac::create([
                        'name' => 'كلية ' . $faculty->name . ' ' . $university->name,
                        'university_id' => $university->id,
                        'faculty_id' => $faculty->id,
                    ]);
                }
                $edges = FacultyEdge::where('TempName',$facultyEdge->TempName)->get();
                foreach ($edges as $facultyEdge) {

                    $facultyEdge->UniFac()->associate($unifac);
                    $facultyEdge->editor()->associate(auth()->user()->member);
                    $facultyEdge->save();
                }
            } else {
                $facultyEdge->editor()->associate(auth()->user()->member);
                $facultyEdge->save();
            }
            return redirect()->route('tansik.edges.edit');
        }
    }
    public function confirm(Request $request, FacultyEdge $facultyEdge)
    {
        $request->validate([
            'name' => 'required|exists:faculty_edges,TempName',
            'is_right' => 'sometimes|boolean',
            'is_faculty' => 'required_without:is_right|boolean',
            'university' => 'required_if:is_faculty,1|exists:universities,id',
            'faculty' => 'required_if:is_faculty,1|exists:faculties,id',
        ]);
        //Check it's not already confirmed
        if(!$facultyEdge->confirmed())
        {
            $edges = FacultyEdge::where('TempName', $facultyEdge->TempName)->get();
            if ($request->has('is_right')) {
                //Is correct => confirm only
                foreach ($edges as $facultyEdge) {
                    $facultyEdge->update([
                        'confirmed' => true,
                    ]);
                    $facultyEdge->confirmer()->associate(auth()->user()->member);
                    $facultyEdge->save();
                }

            } else {
                //Not right => correct it
                if ($request->is_faculty) {
                    //Is faculty
                    $university = University::find($request->university);
                    $faculty = Faculty::find($request->faculty);

                    $unifac = UniFac::where('university_id', $request->university)->where('faculty_id', $request->faculty)->first();
                    if (is_null($unifac)) {
                        //Does not exist
                        $unifac = UniFac::create([
                            'name' => 'كلية ' . $faculty->name . ' ' . $university->name,
                            'university_id' => $university->id,
                            'faculty_id' => $faculty->id,
                            'confirmed' => true,
                        ]);
                    }
                    foreach ($edges as $facultyEdge) {

                        $facultyEdge->UniFac()->associate($unifac);
                        $facultyEdge->confirmer()->associate(auth()->user()->member);
                        $facultyEdge->save();
                    }
                } else {
                    //Is institute
                    foreach ($edges as $facultyEdge) {
                        $facultyEdge->UniFac()->dissociate();
                        $facultyEdge->confirmer()->associate(auth()->user()->member);
                        $facultyEdge->save();
                    }
                }
            }
        }
        return redirect()->route('tansik.edges.confirm_view');
    }

    public function all_member_counts()
    {
        $members = Member::hasStatus('current')->pluck('name', 'id');
        $countData = collect();
        foreach ($members as $id => $name) {
            $temp = collect(['member' => $name]);
            $count = FacultyEdge::where('edit_by', $id)->distinct('TempName')->count();
            $countConfirm = FacultyEdge::where('confirmed_by', $id)->distinct('TempName')->count();
            $temp->put('count', $count);
            $temp->put('countConfirm', $countConfirm);
            $countData->push($temp->toArray());
        }
        $countData = $countData->sortByDesc(function($item) {
            return $item['countConfirm'] + $item['count'];
        });
        $all = FacultyEdge::where('confirmed_by', null)->count();
        return view('admins.edges',['counts' => $countData])->with(compact('all'));

    }

}
