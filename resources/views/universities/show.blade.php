@extends('layouts.app')
@section('title', $page->university->name)
@php
    $breadcrumbItems = [
        ['name' => 'الرئيسية', 'url' => route('home')],
        ['name' => 'الجامعات', 'url' => route('universities.index')],
        ['name' => $page->university->name, 'url' => route('universities.show', $page->university)],
    ];
@endphp
<x-schema-breadcrumb :items="$breadcrumbItems" />
@section('content')
@php /** @var \App\DataTransferObjects\Tansik\UniversityShowPageData $page */ @endphp
    <nav aria-label="مسار التنقل">
        <ol class="breadcrumb bg-transparent px-0 mb-3">
            <li class="breadcrumb-item"><a href="{{ route('universities.index') }}">الجامعات</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->university->name }}</li>
        </ol>
    </nav>
    <h1 class="h3 mb-2">{{ $page->university->name }}</h1>
    @if ($page->university->type)
    <p class="text-muted mb-4">النوع: {{ $page->university->type }}</p>
    @endif
    <h2 class="h5 mb-3">الكليات والمعاهد</h2>
    @if ($page->colleges->isEmpty())
    <p>لا توجد كليات أو معاهد مفعّلة في الدليل لهذه الجامعة بعد.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم</th>
                    <th>الكلية / التخصص</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($page->colleges as $college)
                <tr>
                    <td>
                        <a href="{{ route('colleges.show', $college) }}">{{ $college->name }}</a>
                    </td>
                    <td>{{ $college->faculty?->name ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <p class="mt-4">
        <a href="{{ route('colleges.index') }}" class="btn btn-outline-primary">كل الكليات</a>
        <a href="{{ route('tansik.previous_edges') }}" class="btn btn-outline-secondary">تنسيق السنوات السابقة</a>
    </p>
@endsection
