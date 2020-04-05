<?php

namespace App\Http\Controllers;

use App\Notifications\PostApprovedNotification;
use App\Models\Team\Member;
use App\Models\Team\Post;
use App\Models\Team\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
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
        if (auth()->check() && auth()->user()->isTeamMember()) {
            if (auth()->user()->isAdmin()) {
                return view('posts.index')->with('posts', Post::orderBy('updated_at', 'desc')->paginate(config('app.pagination_max')));
            }
            return view('posts.index')->with('posts', Post::all_for_member(auth()->user()->member));
        }
        return view('posts.index')->with('posts', Post::all_for_public());
    }

    public function view_user_posts(Member $member)
    {
        session()->flash('member', $member->name);
        return view('posts.index')->with('posts', Post::all_for_member(auth()->user()->member,true));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->getTagsForSelector();
        $members = Member::pluck('name','id');
        return view('posts.create')->with(compact('tags'))->with(compact('members'));
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
            'cowriter' => 'nullable|integer|exists:members,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $post = Post::create([
            'content_before_review' => $request->content,
            'state' => $request->is_draft ? config('team.posts.status.DRAFT') : config('team.posts.status.UNDER_REVIEW')
        ]);
        $post->writer()->associate(auth()->user()->member);
        if ($request->has('cowriter') && $request->cowriter != 0) {
            $post->cowriter()->associate($request->cowriter);
        } else {
            $post->cowriter()->dissociate();
        }
        $post->save();
        foreach ($request->tags as $tag_id) {
            if (Tag::where('id', $tag_id)->exists()) {
                $post->tags()->attach($tag_id);
            }
        }

        if (!$request->is_draft) {
            Notification::send(\App\User::teamMembers()->except([$post->writer->id, auth()->user()->id]), new PostApprovedNotification($post));
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
        return view('posts.show', ['post' => $post]);
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
        $members = Member::pluck('name', 'id');
        $tagsSelected = $this->getTagsForSelector($post->tags->pluck('name', 'id'));
        return view('posts.edit')
            ->with(compact('post'))
            ->with(compact('tags'))
            ->with(compact('tagsSelected'))
            ->with(compact('members'));
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
            'cowriter' => 'nullable|integer|exists:members,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $post->update([
            'content_before_review' => $request->content,
            'state' => $request->is_draft ? config('team.posts.status.DRAFT') : config('team.posts.status.UNDER_REVIEW')
        ]);
        if ($request->has('cowriter') && $request->cowriter != 0) {
            $post->cowriter()->associate($request->cowriter);
        } else {
            $post->cowriter()->dissociate();
        }
        $post->save();
        $post->tags()->sync($request->tags);

        session()->flash('success', 'Post Updated Successfully!');
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
        return back();
    }

    public function forceDelete($post)
    {
        $post = Post::withTrashed()->find($post);
        if (is_null($post)) {
            session()->flash('error', 'The Post doesn\'t exist!');
        } else {
            $post->forceDelete();
            session()->flash('success', 'Post Deleted Successfully!');
        }
        return redirect()->route('admins.all-posts');
    }
    public function restore($post)
    {
        $post = Post::withTrashed()->find($post);
        if (is_null($post)) {
            session()->flash('error', 'The Post doesn\'t exist!');
        } else {
            $post->restore();
            session()->flash('success', 'Post restored Successfully!');
        }
        return redirect()->route('admins.all-posts');
    }

    public function approve_post(Post $post)
    {
        $tags = $this->getTagsForSelector();
        $members = Member::pluck('name', 'id');
        $tagsSelected = $this->getTagsForSelector($post->tags->pluck('name', 'id'));
        return view('admins.approve-post')
            ->with(compact('post'))
            ->with(compact('tagsSelected'))
            ->with(compact('tags'))
            ->with(compact('members'));
    }

    public function all_post_for_admin(Request $request)
    {
        $members = Member::has('posts')->pluck('name','id');
        $states = collect(config('team.posts.status'))->keys()->transform(function($s) {
            return ['key'=> $s, 'value' => \Str::title(str_replace('_', ' ', $s))];
        })->keyBy('key')->transform(function($s) {
            return $s['value'];
        });

        //Get Existing Filters
        $Posts = Post::orderBy('updated_at', 'desc');
        $DeletedPosts = Post::onlyTrashed()->orderBy('deleted_at', 'desc');
        if ($request->has('member')) {
            $Posts = $Posts->whereHas('writer',function($q) use ($request) {
                $q->where('id', $request->member);
            });
        }
        if ($request->has('state')) {
            $Posts = $Posts->where('state', config('team.posts.status.'. $request->state));
        }
        return view('admins.posts')->with('posts', $Posts->paginate(config('app.pagination_max')))
            ->with('deleted_posts', $DeletedPosts->paginate(config('app.pagination_max')))
            ->with(compact('members'))
            ->with(compact('states'));
    }

    public function approve(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'nullable|array',
            'state' => 'required|integer',
            'cowriter' => 'nullable|integer|exists:members,id',
            'rate' => [Rule::RequiredIf($request->state >= config('team.posts.status.APPROVED')), 'numeric', 'max:5', 'min:0'],
        ]);
        $isPosted = $request->state == config('team.posts.status.POSTED');
        $validator->sometimes('fb_link', 'url|required', function () use ($isPosted) {
            return $isPosted;
        });
        $isApproved = $request->state == config('team.posts.status.APPROVED');
        $validator->sometimes('content', 'required|string|min:10', function () use ($isApproved) {
            return $isApproved;
        });
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if ($post->state < config('team.posts.status.APPROVED') && $request->state >= config('team.posts.status.APPROVED')) {
            //Newly Approved
            $post->approver()->associate(auth()->user()->member);
            Notification::send($post->writer->user, new PostApprovedNotification($post));
        }
        $post->update([
            'content' => $request->content,
            'state' => $request->state
        ]);
        if ($request->has('cowriter') && $request->cowriter != 0) {
            $post->cowriter()->associate($request->cowriter);
        } else {
            $post->cowriter()->dissociate();
        }
        if ($request->has('fb_link')) {
            $post->fb_link = $request->fb_link; //save() is called below anyway.
        }
        if ($request->has('rate')) {
            $post->rate = $request->rate; //save() is called below anyway.
        }
        $post->save();
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
