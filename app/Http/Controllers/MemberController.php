<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Member::class, 'member');
    }

    public function index()
    {
        return view('members.index')->with('members', Member::paginate(config('app.pagination_max')));
    }

    public function show(Member $member)
    {
        return view('members.show')->with(compact('member'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        //Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'education' => 'required|string',
            'title' => 'nullable|string',
            'text' => 'nullable|string|min:10',
            'status' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000|dimensions:ratio=1/1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        //Store Member
        $member = new Member([
            'name' => $request->name,
            'education' => $request->education,
            'title' => $request->title,
            'text' => $request->text,
            'status' => str_getcsv($request->status)
        ]);

        $member->save();

        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $member->addMediaFromRequest('image')->withResponsiveImages()->toMediaCollection('profile-photo');
        }

        return response()->json([
            'success' => true,
            'message' => 'The Member was added successfully!'
        ]);
    }

    public function edit(Member $member)
    {
        return view('members.edit')->with(compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        //Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'education' => 'required|string',
            'title' => 'nullable|string',
            'text' => 'nullable|string|min:10',
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10000|dimensions:ratio=1/1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $member->clearMediaCollection('profile-photo');
            $member->addMediaFromRequest('image')->withResponsiveImages()->toMediaCollection('members');
        }
        //Store Member
        $update = [
            'name' => $request->name,
            'education' => $request->education,
            'title' => $request->title,
            'text' => $request->text
        ];
        $member->update($update);

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Member was updated successfully!'
        ]);
    }


    public function destroy(Member $member)
    {
        $name = $member->name;
        //$member->delete();
        session()->flash('success', "${name} was deleted successfully!");
        return redirect()->route('members.index');
    }
}
