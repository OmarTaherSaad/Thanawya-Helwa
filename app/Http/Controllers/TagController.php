<?php

namespace App\Http\Controllers;

use App\Models\Team\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags',Tag::paginate(config('app.pagination_max') * 2));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name'
        ]);
        Tag::create($request->all());
        session()->flash('success','Tag Created Successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        session()->forget('member');
        session()->flash('tag',$tag->name);
        if (auth()->check() && auth()->user()->isTeamMember()) {
            if (auth()->user()->isAdmin()) {
                $posts = $tag->posts();
            } else {
                $posts = $tag->posts()->where('state', '>', config('team.posts.status.DRAFT'));
            }
        } else {
            $posts = $tag->posts()->where('state', config('team.posts.status.POSTED'))
        }
        $members = \App\Models\Team\Member::has('posts')->pluck('name', 'id');
        $states =  \App\Models\Team\Post::getStatesForFilter();
        $count = $posts->count();
        $posts = $posts->paginate(config('app.pagination_max'));
        return view('posts.index',[
            compact('posts'),
            compact('members'),
            compact('count'),
            compact('count'),
            compact('states')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit')->with(compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name,' . $tag->id
        ]);
        $tag->update($request->all());
        session()->flash('success', 'Tag Updated Successfully!');
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        session()->flash('success', 'Tag Deleted Successfully!');
        return redirect()->route('tags.index');
    }
}
