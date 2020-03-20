@extends('layouts.app-members')
@section('title',"View Post")

@section('content')
    <div class="row my-1">
        <div class="col-12 col-md-auto">
        <a href="{{ route('posts.index') }}" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Posts</a>
        </div>
    </div>
    <section class="bg-gradient">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-8">
                <h4>Written by: {{ $post->writer->name }}</h4>
                <h4>Status: {{ $post->status }}</h4>
                @if($post->approved())
                <h4>Approved by: {{ $post->approver->name }}</h4>
                @endif
                <h4>Last Updated at: {{ $post->updated_at->toDayDateTimeString() }}</h4>
                <h4>Created at: {{ $post->created_at->toDayDateTimeString() }}</h4>
                @if($post->trashed())
                <h4>Deleted at: {{ $post->deleted_at->toDayDateTimeString() }}</h4>
                @endif
            </div>
            @if(Auth::check() && Auth::user()->isTeamMember())

                @if($post->state > config('team.posts.status.DISMISSED'))
                <div class="col-12 col-md-8">
                    <label for="content"><h3 class="text-center"><u>Final Content</u></h3></label>
                    <textarea rows="10" readonly style="font-size: 1.5rem;" class="text-right form-control" id="content">
                        {!! $post->content !!}
                    </textarea>
                </div>
                @endif
                <div class="col-12 col-md-8">
                    <label for="content_before_review"><h3><u>Content Before Review</u></h3></label>
                    <textarea rows="10" readonly style="font-size: 1.5rem;" class="text-right form-control" id="content_before_review">
                        {!! $post->content_before_review !!}
                    </textarea>
                </div>
                @if($post->with_link())
                <div class="col-12 col-md-8">
                    <h3 class="text-center"><a href="{{ $post->fb_link }}" rel="noreferrer" target="_blank">Open FB Post</a></h3>
                </div>
                @endif

            @else
                <div class="col-12 col-md-8">
                    <p style="font-size: 1.1rem;" class="m-1 py-1 text-right">
                        {!! $post->content !!}
                    </p>
                </div>
            @endif
        </div>
        <div class="row justify-content-center mt-3">
            @foreach( $post->tags as $tag )
            <div class="col-4 col-md-2 my-2">
                @include('containers.tag')
            </div>
            @endforeach
        </div>
    </section>
@endsection
