@extends('layouts.app')
@section('title','All Posts')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <a class="btn btn-primary" href="{{ route('posts.create') }}">Add Post</a>
    </div>
</div>
<div class="row justify-content-center text-left mt-5">
    <div class="col-12 col-6">
        <form class="form-inline" {{ route('admins.all-posts') }} id="filterForm" dir="ltr">
            <div class="form-group m-2">
                <label for="state">Filter By Status</label>
                <select class="form-control" name="state" id="state" onchange="this.form.submit()">
                    <option value="0" disabled selected>No Filter</option>
                    @foreach ($states as $key => $state)
                    <option value="{{ $key }}" @if(Request::get('state') == $key) selected  @endif>{{ $state }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group m-2">
                <label for="member">Filter By Member</label>
                <select class="form-control" name="member" id="member" onchange="this.form.submit()">
                    <option value="0" disabled selected>No Filter</option>
                    @foreach ($members as $key => $member)
                    <option value="{{ $key }}" @if(Request::get('member') == $key) selected  @endif>{{ $member }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group m-2">
                <label for="from_date">From Date:</label>
                <input type="date" class="form-control" name="from_date" id="from_date" @if(Request::has('from_date')) value="{{ Request::get('from_date') }}"  @endif>
            </div>
            <div class="form-group m-2">
                <label for="to_date">To Date:</label>
                <input type="date" class="form-control" name="to_date" id="to_date" @if(Request::has('member'))
                    value="{{ Request::get('from_date') }}" @endif>
            </div>
            <button type="submit" class="btn btn-success m-2">Filter</button>
            <button type="button" onclick="resetFilters();this.form.submit();" class="btn btn-danger m-2">Reset</button>
        </form>
    </div>
</div>
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <h1>All Posts of TH</h1>
        <h4>Count: {{ $count . ' ' . \Str::plural('post',$count) }}</h4>
    </div>
</div>
<div class="row justify-content-center text-center my-3">
    <div class="col-12 col-6">
        <a class="btn btn-secondary" data-toggle="collapse" href="#copostCollapse" role="button" aria-expanded="false"
            aria-controls="copostCollapse">
            Coposts Data
        </a>
        <div class="collapse" id="copostCollapse">
            <h4>Coposts data</h4>
            <div class="card card-body">
                <table class="table table-bordered table-hover table-responsive" dir="ltr">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Members</th>
                            <th>Coposts Count</th>
                            <th>Coposts with:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coposts as $data)
                        <tr>
                            <td>{{ $data['member'] }}</td>
                            <td>{{ $data['count'] }}</td>
                            <td>
                                <ul class="list-group">
                                    @forelse ($data['cowriters'] as $writer)
                                    <li class="list-group-item">{{ $writer }}</li>
                                    @empty
                                    <li class="list-group-item">No one.</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach( $posts as $post )
    <div class="col-6 col-md-4">
        @include('containers.post')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $posts->links() !!}
    </div>
</div>
<br>
<hr>
<h1 class="text-center">Deleted Posts</h1>
<br>
<div class="row">
    @foreach( $deleted_posts as $post )
    <div class="col-6 col-md-4">
        @include('containers.post')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $deleted_posts->links() !!}
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
                <p>Do you really want to delete <span id="DeletePostName"></span> ? Note that this action cannot be
                    undone.</p>
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
    function resetFilters() {
        $("#filterForm select").prop('selectedIndex',0);
        $("#filterForm input").val('');
    }
</script>
@endsection
