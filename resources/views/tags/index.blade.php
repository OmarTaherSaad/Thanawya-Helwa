@extends('layouts.app-members')
@section('title','All Tags')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <a class="btn btn-primary" href="{{ route('tags.create') }}">Add Tag</a>
    </div>
</div>
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <h1>Tags for TH Posts</h1>
    </div>
</div>
<div class="row">
    @foreach( $tags as $tag )
    <div class="col-4 col-md-2">
        @include('containers.tag')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $tags->links() !!}
    </div>
</div>
@auth
@can('delete', $tags->first())
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deleting a Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete <span id="DeleteTagName"></span> ? Note that this action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form id="deleteTag" method="POST">
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
            $("#deleteTag").attr('action',$(e.target).data('id'));
            $("#DeleteTagName").html($(e.target).data('name'));
        });
    </script>
@endsection
