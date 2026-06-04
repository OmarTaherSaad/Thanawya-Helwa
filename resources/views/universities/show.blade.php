@extends('layouts.app')
@section('title', $page->university->name)
@section('content')
@php /** @var \App\DataTransferObjects\Tansik\UniversityShowPageData $page */ @endphp
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
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
            <thead class="thead-dark">
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
</div>
@endsection
