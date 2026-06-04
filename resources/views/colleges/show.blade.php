@extends('layouts.app')
@section('title', $page->college->name)
@php
    $breadcrumbItems = [
        ['name' => 'الرئيسية', 'url' => route('home')],
        ['name' => 'كليات ومعاهد مصر', 'url' => route('colleges.index')],
    ];
    $uni = $page->college->university;
    if ($uni && $uni->is_active && $uni->slug) {
        $breadcrumbItems[] = ['name' => $uni->name, 'url' => route('universities.show', $uni)];
    }
    $breadcrumbItems[] = ['name' => $page->college->name, 'url' => route('colleges.show', $page->college)];
@endphp
<x-schema-breadcrumb :items="$breadcrumbItems" />
@section('content')
@php /** @var \App\DataTransferObjects\Tansik\CollegeShowPageData $page */ @endphp
    <nav aria-label="مسار التنقل">
        <ol class="breadcrumb bg-transparent px-0 mb-3">
            <li class="breadcrumb-item"><a href="{{ route('colleges.index') }}">كليات ومعاهد مصر</a></li>
            @if ($page->college->university && $page->college->university->is_active && $page->college->university->slug)
            <li class="breadcrumb-item"><a href="{{ route('universities.show', $page->college->university) }}">{{ $page->college->university->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $page->college->name }}</li>
        </ol>
    </nav>
    <h1 class="h3 mb-2">{{ $page->college->name }}</h1>
    <p class="text-muted mb-4">
        {{ $page->college->university?->name }}
        @if($page->college->faculty)
        — كلية {{ $page->college->faculty->name }}
        @endif
    </p>
    <h2 class="h5 mb-3">الحد الأدنى (تنسيق سنوات سابقة)</h2>
    @if ($page->edges->isEmpty())
    <p>لا توجد بيانات تنسيق مرتبطة بهذه الصفحة بعد.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>السنة</th>
                    <th>الشعبة</th>
                    <th>الحد الأدنى</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($page->edges as $edge)
                <tr>
                    <td>{{ $edge->year }}</td>
                    <td>{{ $edge->section === 'E' ? 'علمي' : ($edge->section === 'A' ? 'أدبي' : $edge->section) }}</td>
                    <td>{{ number_format((float) $edge->edge, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <p class="mt-4">
        <a href="{{ route('tansik.previous_edges') }}" class="btn btn-outline-primary">تنسيق كل الكليات عبر السنوات</a>
    </p>
@endsection
