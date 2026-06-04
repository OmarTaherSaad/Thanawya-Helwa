@extends('layouts.app')
@section('title', $page->college->name)
@section('content')
@php /** @var \App\DataTransferObjects\Tansik\CollegeShowPageData $page */ @endphp
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('colleges.index') }}">كليات ومعاهد مصر</a></li>
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
            <thead class="thead-dark">
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
</div>
@endsection
