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
        $edges = FacultyEdge::orderBy('created_at')->where('unifac_id',null)->get()->unique('TempName');
        $count = FacultyEdge::where('edit_by', auth()->user()->member->id)->count();
        $edges = $this->paginate($edges, config('app.pagination_max'), $request->page)->withPath(route('tansik.edges.index'));
        return view('tansik-work.index')
            ->with(compact('edges'))
            ->with(compact('count'));
    }

    public function edit(FacultyEdge $facultyEdge = null)
    {
        if (is_null($facultyEdge))
        {
            $facultyEdge = FacultyEdge::where('unifac_id', null)->inRandomOrder()->limit(1)->lockForUpdate()->first();
            if(is_null($facultyEdge))
            {
                return redirect()->route('tansik.edges.index');
            }
        }
        $universities = University::where('type','governmental')->pluck('name','id');
        $faculties = Faculty::pluck('name','id');

        $count = FacultyEdge::where('edit_by',auth()->user()->member->id)->count();
        return view('tansik-work.edit')->with(compact('faculties'))
            ->with(compact('universities'))
            ->with(compact('count'))
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
                        'name' => 'كلية ' . $faculty->name . ' ' . $university->name
                    ]);
                    $unifac->faculty()->associate($faculty);
                    $unifac->university()->associate($university);
                    $unifac->save();
                }
                $edges = FacultyEdge::where('TempName',$facultyEdge->TempName)->get();
                foreach ($edges as $facultyEdge) {

                    $facultyEdge->UniFac()->associate($unifac);
                    $facultyEdge->editor()->associate(auth()->user()->member);
                    $facultyEdge->save();
                }
            }
            return redirect()->route('tansik.edges.edit');
        }
    }

    public function all_member_counts()
    {
        $members = Member::hasStatus('current')->pluck('name', 'id');
        $countData = collect();
        foreach ($members as $id => $name) {
            $temp = collect(['member' => $name]);
            $cowriters = collect();
            $count = FacultyEdge::where('edit_by', $id)->count();
            $temp->put('count', $count);
            $countData->push($temp->toArray());
        }
        $countData = $countData->sortByDesc('count');

        return view('admins.edges',['counts' => $countData]);

    }

}
