@extends('layouts.app')
@section('title','All Edge Edits')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <h1>All Edges Edits</h1>
        <h3>Remaining Edges: {{ $all }}</h3>
    </div>
</div>
<div class="row justify-content-center text-center my-3">
    <div class="col-12 col-6">
       <table class="table table-bordered table-hover table-responsive" dir="ltr">
            <thead class="thead-inverse">
                <tr>
                    <th>Members</th>
                    <th>Edits Count</th>
                    <th>Confirms Count</th>
                    <th>Confirms 2 Count</th>
                    <th>Total Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($counts as $c)
                <tr>
                    <td>{{ $c['member'] }}</td>
                    <td>{{ $c['count'] }}</td>
                    <td>{{ $c['countConfirm'] }}</td>
                    <td>{{ $c['countConfirm2'] }}</td>
                    <td>{{ $c['count'] + $c['countConfirm'] + $c['countConfirm2'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- Deleting Modal --}}
@endsection
