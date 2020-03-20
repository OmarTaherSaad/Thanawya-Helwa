@extends('layouts.app-members')
@section('title','All Posts')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <a class="btn btn-primary" href="{{ route('posts.create') }}">Add Post</a>
    </div>
</div>
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        @if(session()->has('member'))
        <h1>Posts from {{ session('member') }}</h1>
        @elseif(session()->has('tag'))
        <h1>Posts with tag &rarr; {{ session('tag') }}</h1>
        @else
        <h1>All Posts of TH</h1>
        @endif
    </div>
</div>
<div class="row">
    @foreach( $posts as $post )
    <div class="col-6 col-md-4 my-2">
        @include('containers.post')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $posts->links() !!}
    </div>
</div>
@auth
@can('delete', $posts->first())
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deleting a Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete <span id="DeletePostName"></span> ? Note that this action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form id="deletePost" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" type="submit">Yes, Delete!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan
@endauth
{{-- Deleting Modal --}}
@endsection

@section('scripts')
    <script>
        $(".deleteBtn").on('click',(e) => {
            e.preventDefault;
            $("#deletePost").attr('action',$(e.target).data('id'));
            $("#DeletePostName").html($(e.target).data('name'));
        });
    </script>
@endsection
