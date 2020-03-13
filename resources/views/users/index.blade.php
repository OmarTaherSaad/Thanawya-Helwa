@extends('layouts.app-members')
@section('title','View All Users')
@section('head')
<style>
    .fit-content {
        white-space: nowrap;
        width: 1%;
    }
</style>
@endsection
@section('content')
<div id="edgesApp" class="m-2">
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>All Registered Users</h2>
        </div>
    </div>
    <div class="row">
        <h4 class="d-block d-sm-none">Move right & left to see all details.</h4>
        <div class="col-12 table-responsive">
            <table class="table table-light table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle">Edit</th>
                        <th class="align-middle">Delete</th>
                        <th class="align-middle">Name</th>
                        <th class="align-middle">Email</th>
                        <th class="align-middle">Mobile No.</th>
                        <th class="align-middle">Used Service</th>
                        <th class="align-middle">Role</th>
                        <th class="align-middle">Created at</th>
                        <th class="align-middle">Updated at</th>
                        <th class="align-middle">Email Verified at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('users.edit',['user' => $user]) }}">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('users.destroy',['user' => $user]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $user->name }} account?')">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger">Delete</a>
                            </form>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number }}</td>
                        <td>{{ \Str::title($user->provider) ?? 'No Service' }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
                        <td>{{ $user->email_verified_at ? $user->email_verified_at->diffForHumans() : 'Not Verified yet' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            {!! $users->links() !!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(".editUser").on('click',(e) => {
            e.preventDefault;
            $(".productForm").attr('action',$(e.target).data('id'));
            $(".editProduct").html($(e.target).data('name'));
            $("#editPM").val($(e.target).data('multiplier'));
        });
    </script>
@endsection
