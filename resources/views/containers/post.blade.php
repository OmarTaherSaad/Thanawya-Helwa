@php
$class = 'bordered border-';
    switch($post->state){
        case config('team.posts.status.DRAFT'):
            $class .='light';
            break;
        case config('team.posts.status.UNDER_REVIEW'):
            $class .='warning';
            break;
        case config('team.posts.status.APPROVED'):
            $class .='success';
            break;
        case config('team.posts.status.DISSMISSED'):
            $class .='danger';
            break;
        case config('team.posts.status.POSTED'):
            $class .='primary';
            break;
        case config('team.posts.status.SCHEDULED'):
            $class .='dark';
            break;
        case config('team.posts.status.DRAFTED_ON_PAGE'):
            $class .='secondary';
            break;
    }
@endphp
<div class="card text-center h-100 shadow {{ $class }}" style="border-width: 3px;">
    <div class="card-body p-1 p-md-2">
        <h5 class="card-title mb-1"><a href="{{ route('posts.show',['post' => $post]) }}">{{$post->small_part()}}</a></h5>
        @if($post->tags->isNotEmpty())
        <hr>
        @foreach ($post->tags as $tag)
            <a class="btn btn-outline-primary my-1" href="{{ route('tags.show',['tag'=>$tag]) }}">{{ $tag->name }}</a>
        @endforeach
        <hr>
        @endif
        <h5>Status: {{ $post->status . ($post->rated() ? ' | Rate: ' . $post->rate : '') }}</h5>
        <hr>
        <h6>By: {{ $post->writer->name }}</h6>
        <hr>
        @if($post->trashed())
        <h6>Deleted at: {{ $post->deleted_at->locale('en-US')->diffForHumans() }}</h6>
        @endif
        <h6>Last Updated: {{ $post->updated_at->locale('en-US')->diffForHumans() }}</h6>
        @if($post->with_link())
            <a href="{{ $post->fb_link }}" rel="noreferrer" target="_blank" class="btn btn-primary">FB Link</a>
        @endif
        @auth
        @if($post->trashed())
            @can('restore', $post)
            <form action="{{ $post->getLinkToRestore() }}" method="POST" onsubmit="return confirm('Are you sure you want to restore this post?')">
                @csrf
                <button type="submit" class="btn btn-info">Restore</button>
            </form>
            @endcan
            @can('forceDelete', $post)
            <form action="{{ $post->getLinkToForceDelete() }}" method="POST"
                onsubmit="return confirm('Are you sure you want to force delete this post? this action is irreversible')">
                @csrf
                <button type="submit" class="btn btn-danger">Force Delete</button>
            </form>
            @endcan
        @else
            @if(auth()->user()->isAdmin())
                <a href="{{ $post->getLinkToApprove() }}" class="btn btn-success">Edit/Approve</a>
            @else
                @can('update', $post)
                <a href="{{ $post->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
                @endcan
                @can('approve', $post)
                <a href="{{ $post->getLinkToApprove() }}" class="btn btn-success">Approve</a>
                @endcan
            @endif
            @can('delete', $post)
            <a href="#deleteModal" data-id="{{ $post->getLinkToDelete() }}" data-name="{{ $post->name }}" data-toggle="modal"
                class=" deleteBtn btn btn-danger">Delete</a>
            @endcan
        @endif
        @endauth
    </div>
</div>
