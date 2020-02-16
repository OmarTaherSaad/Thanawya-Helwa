@extends('layouts.app')
@section('title','All Members')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <a class="btn btn-primary" href="{{ route('members.create') }}">Add Member</a>
    </div>
</div>
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <h1>Members of Thanawya Helwa</h1>
    </div>
</div>
<div class="row">
    @foreach( $members as $member )
    <div class="col-12 col-md-4">
        @include('containers.member')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $members->links() !!}
    </div>
</div>
@auth
@can('delete', $members->first())
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deleting a Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete <span id="DeleteMemberName"></span> ? Note that this action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form id="deleteMember" method="POST">
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
            $("#deleteMember").attr('action',$(e.target).data('id'));
            $("#DeleteMemberName").html($(e.target).data('name'));
        });
    </script>
@endsection
