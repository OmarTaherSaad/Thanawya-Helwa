@extends('layouts.app')
@section('title', 'الجامعات')
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">الجامعات</h1>
    <p class="lead text-muted mb-3">جامعات مرتبطة ببيانات التنسيق على الموقع.</p>
    <p><a href="{{ route('colleges.index') }}">عرض كليات ومعاهد مصر</a></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>الجامعة</th>
                    <th>النوع</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universities as $university)
                <tr>
                    <td>
                        <a href="{{ route('universities.show', $university) }}">{{ $university->name }}</a>
                    </td>
                    <td>{{ $university->type ?: '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $universities->withQueryString()->links() }}
</div>
@endsection
