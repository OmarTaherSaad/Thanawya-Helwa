@extends('layouts.app')
@section('title','كل البيانات')
@section('content')
<div class="container pb-5 mb-5">
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-md-6">
            <h1>بيانات التنسيق</h1>
            <h3>إنت عملت: {{ $count }} تعديل/تعديلات</h3>
            <h3>إنت عملت: {{ $countConfirm }} تأكيد/تأكيدات</h3>
            <h3>إنت عملت: {{ $countConfirm2 }} تأكيد/تأكيدات</h3>
            {{-- <a href="{{ route('tansik.edges.edit') }}" class="btn btn-primary">تعديل البيانات</a> --}}
            <a href="{{ route('tansik.edges.confirm_view') }}" class="btn btn-success">تأكيد البيانات</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('tansik.edges.confirm_view2') }}" class="btn btn-warning">تأكيد البيانات 2</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>University</th>
                        <th>Faculty or Institute</th>
                        <th>Faculty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $edges as $edge )
                    <tr>
                        <td>{{ $edge->TempName }}</td>
                        <td>{{ $edge->UniFac ? $edge->UniFac->university->name : 'مفيش' }}</td>
                        <td>{{ $edge->UniFac ? $edge->UniFac->hasFaculty() ? 'كلية' : 'معهد' : 'مفيش' }}</td>
                        <td>{{ $edge->UniFac ? $edge->UniFac->faculty->name : 'مفيش' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            {!! $edges->links() !!}
        </div>
    </div>
</div>
@endsection
