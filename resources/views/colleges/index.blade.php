@extends('layouts.app')
@section('title', 'كليات ومعاهد مصر')
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">كليات ومعاهد مصر</h1>
    <p class="lead text-muted">روابط لكل كلية أو معهد مرتبط ببيانات التنسيق على الموقع.</p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>الاسم</th>
                    <th>الجامعة</th>
                    <th>الكلية / المعهد</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colleges as $college)
                <tr>
                    <td>
                        <a href="{{ route('colleges.show', $college) }}">{{ $college->name }}</a>
                    </td>
                    <td>{{ $college->university?->name }}</td>
                    <td>{{ $college->faculty?->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $colleges->withQueryString()->links() }}
</div>
@endsection
