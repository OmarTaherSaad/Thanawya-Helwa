@extends('layouts.app')
@section('title', 'كليات ومعاهد مصر')
<x-schema-breadcrumb :items="[
    ['name' => 'الرئيسية', 'url' => route('home')],
    ['name' => 'كليات ومعاهد مصر', 'url' => route('colleges.index')],
]" />
@section('content')
    <h1 class="h3 mb-3">كليات ومعاهد مصر</h1>
    <p class="lead text-muted">روابط لكل كلية أو معهد مرتبط ببيانات التنسيق على الموقع.</p>
    <p class="mb-3"><a href="{{ route('universities.index') }}">عرض الجامعات</a></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
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
@endsection
