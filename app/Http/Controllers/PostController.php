<?php

namespace App\Http\Controllers;

use App\Models\Team\Member;
use App\Models\Team\Post;
use App\Models\Team\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Post::class);

        session()->forget(['member', 'tag']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            return view('posts.index')->with('posts',Post::orderBy('updated_at', 'desc')->paginate(config('app.pagination_max')));
        }
        return view('posts.index')->with('posts',Post::all_for_member(auth()->user()->member));
    }

    public function view_user_posts(Member $member)
    {
        session()->flash('member',$member->name);
        return view('posts.index')->with('posts',$member->posts()->orderBy('updated_at', 'desc')->paginate(config('app.pagination_max')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->getTagsForSelector();
        return view('posts.create')->with(compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'nullable|array',
            'content' => 'required|string|min:10',
            'is_draft' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $post = Post::create([
            'content_before_review' => $request->content,
            'state' => $request->is_draft ? config('team.posts.status.DRAFT') : config('team.posts.status.UNDER_REVIEW')
        ]);
        $post->writer()->associate(auth()->user()->member);
        $post->save();
        foreach ($request->tags as $tag_id ) {
            if (Tag::where('id',$tag_id)->exists()) {
                $post->tags()->attach($tag_id);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Post Saved Successfully!",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show',['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = $this->getTagsForSelector();
        $tagsSelected = $this->getTagsForSelector($post->tags->pluck('name', 'id'));
        return view('posts.edit')
            ->with(compact('post'))
            ->with(compact('tags'))
            ->with(compact('tagsSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'nullable|array',
            'content' => 'required|string|min:10',
            'is_draft' => 'required|boolean',
            'new_state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $post->update([
            'content_before_review' => $request->content,
            'state' => $request->is_draft ? config('team.posts.status.DRAFT') : config('team.posts.status.UNDER_REVIEW')
        ]);
        $post->tags()->sync($request->tags);

        session()->flash('success','Post Updated Successfully!');
        return response()->json([
            'success' => true,
            'message' => "Post Updated Successfully!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        session()->flash('success', 'Post Deleted Successfully!');
        return redirect()->route('posts.index');
    }

    public function approve_post(Post $post)
    {
        $tags = $this->getTagsForSelector();
        $tagsSelected = $this->getTagsForSelector($post->tags->pluck('name', 'id'));
        return view('admins.approve-post')
        ->with(compact('post'))
        ->with(compact('tagsSelected'))
        ->with(compact('tags'));
    }

    public function all_post_for_admin()
    {
        return view('admins.posts')->with('posts', Post::orderBy('updated_at', 'desc')->paginate(config('app.pagination_max')))
        ->with('deleted_posts', Post::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(config('app.pagination_max')));
    }

    public function approve(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'nullable|array',
            'content' => 'required|string|min:10',
            'state' => 'required|integer',
            'fb_link' => [ Rule::RequiredIf($request->state == config('team.posts.status.POSTED')), 'url'],
            'rate' => [ Rule::RequiredIf($request->state >= config('team.posts.status.APPROVED')), 'numeric','max:5','min:0'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if ($request->state > config('team.posts.status.DISMISSED')) {
            $post->update([
                'content' => $request->content,
                'state' => $request->state
            ]);
            if($request->has('fb_link')) {
                $post->fb_link = $request->fb_link; //save() is called below anyway.
            }
            if($request->has('rate')) {
                $post->rate = $request->rate; //save() is called below anyway.
            }
            $post->approver()->associate(auth()->user()->member);
            $post->save();
        } else {
            $post->update([
                'content_before_review' => $request->content,
                'state' => $request->state
            ]);
        }
        $post->tags()->sync($request->tags);

        session()->flash('success', 'Post Approved Successfully!');
        return response()->json([
            'success' => true,
            'message' => "Post Approved Successfully!"
        ]);
    }

    private function getTagsForSelector($elements = null)
    {
        if (is_null($elements)) {
            $elements = Tag::pluck('name', 'id');
        }
        $tags = '[';
        foreach ($elements as $key => $name) {
            $name = addslashes($name);
            $tags .= "{value: '$key', label: '$name'},";
        }
        $tags .= ']';
        return $tags;
    }
}
