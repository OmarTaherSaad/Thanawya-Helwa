<?php

namespace App\Http\Controllers;

use App\Models\Team\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Member::class, 'member');
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
        return view('members.create')->with('users',User::whereIn('role',['THteam','admin'])->pluck('email','id'));
    }

    public function store(Request $request)
    {
        //Validate the input
        $request->validate([
            'name' => 'required|min:2',
            'user_id' => 'sometimes|exists:users,id',
            'title_personal' => 'required|string',
            'title_on_team' => 'nullable|string',
            'text' => 'nullable|string|min:10',
            'status' => 'required|string',
            'image' => 'sometimes|file|mimes:jpeg,jpg,png,gif|max:10000|dimensions:ratio=1/1',
        ]);
        //Store Member
        $member = new Member([
            'name' => $request->name,
            'title_personal' => $request->title_personal,
            'title_on_team' => $request->title_on_team,
            'text' => $request->text,
            'status' => str_getcsv($request->status)
        ]);

        if ($request->has('user_id')) {
            $member->user()->associate($request->user_id);
        }

        $member->save();
        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $member->addMediaFromRequest('image')->withResponsiveImages()->toMediaCollection('members/profile-photos');
        }
        session()->flash('success', 'The Member was added successfully!');
        return redirect()->route('members.index');
    }

    public function edit(Member $member)
    {
        return view('members.edit')->with(compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        //Validate the input
        $request->validate([
            'name' => 'required|min:2',
            'title_personal' => 'required|string',
            'title_on_team' => 'nullable|string',
            'text' => 'nullable|string|min:10',
            'status' => 'required|string',
            'image' => 'sometimes|file|mimes:jpeg,jpg,png,gif|max:10000|dimensions:ratio=1/1',
        ]);
        //Store Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $member->addMediaFromRequest('image')->withResponsiveImages()->toMediaCollection('members/profile-photos');
        }
        $member->save();
        //Store Member
        $update = [
            'name' => $request->name,
            'title_personal' => $request->title_personal,
            'title_on_team' => $request->title_on_team,
            'text' => $request->text,
            'status' => str_getcsv($request->status)
        ];
        if(!$request->user()->isAdmin()) {
            unset($update['status']);
        }
        $member->update($update);



        session()->flash('success', 'Member was updated successfully!');
        return redirect()->route('members.index');
    }


    public function destroy(Member $member)
    {
        $name = $member->name;
        $member->delete();
        session()->flash('success', "${name} was deleted successfully!");
        return redirect()->route('members.index');
    }
}
