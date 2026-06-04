@extends('layouts.app')
@section('title', 'بحث في الدليل')
@section('head')
<style>
    .search-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: .5rem;
    }
    .search-result-link {
        font-size: 1.05rem;
    }
    .search-quick-card:hover {
        box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .08);
    }
</style>
@endsection
@section('content')
@php
    $qTrim = trim($q ?? '');
    $uniCount = $universities->count();
    $collegeCount = $colleges->count();
    $totalHits = $uniCount + $collegeCount;
    $hasAnyResult = $totalHits > 0;
@endphp
<nav aria-label="مسار التنقل" class="mb-3">
        <ol class="breadcrumb mb-0 bg-transparent px-0 py-0 small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">بحث الدليل</li>
        </ol>
    </nav>

    <header class="search-hero border p-4 mb-4">
        <h1 class="h3 mb-2">بحث في دليل الجامعات والكليات</h1>
        <p class="lead mb-3 text-muted mb-md-4">
            لو لسه مش عارف تظبط اسم الجامعة أو الكلية بالكامل، اكتب <strong>أي جزء من الاسم</strong> وهنقترح عليك صفحات جاهزة في الموقع فيها تنسيق السنوات السابقة وروابط مفيدة.
        </p>
        <div class="row">
            <div class="col-lg-7">
                <h2 class="h6 text-primary fw-bold mb-2">إيه اللي بنبحث فيه؟</h2>
                <ul class="mb-0 pe-4 ps-0 small text-muted">
                    <li class="mb-1"><strong>جامعات</strong> الظاهرة في دليل الموقع (الاسم، نوع الجامعة، …).</li>
                    <li class="mb-1"><strong>كليات ومعاهد</strong> مرتبطة بالجامعة (اسم الكلية، عنوان لو متوفر، …).</li>
                    <li>البحث يشمل <strong>حروف من كلمة</strong> جوّه الاسم؛ مش لازم تكتب الاسم كامل.</li>
                </ul>
            </div>
            <div class="col-lg-5 mt-3 mt-lg-0">
                <h2 class="h6 text-secondary fw-bold mb-2">إيه اللي مش هتلاقيه هنا؟</h2>
                <ul class="mb-0 pe-4 ps-0 small text-muted">
                    <li class="mb-1">درجات التنسيق أو «هنجيب كام السنة دي» — ده في صفحات <a href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a> و<a href="{{ route('tansik.coordination_estimate') }}">التقدير التجريبي</a>.</li>
                    <li class="mb-1">مقالات المدونة أو الملفات؛ الصفحة دي للدليل بس.</li>
                </ul>
            </div>
        </div>
    </header>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="get" action="{{ route('search.index') }}" role="search" aria-label="بحث في دليل الجامعات والكليات">
                <label for="search-q" class="fw-bold d-block mb-2">كلمة البحث</label>
                <div class="row g-2 align-items-stretch align-items-md-end">
                    <div class="col-md-8 mb-2 mb-md-0">
                        <input
                            id="search-q"
                            type="search"
                            name="q"
                            value="{{ e($q) }}"
                            class="form-control form-control-lg"
                            placeholder="مثال: عين، هندسة، أزهر، معهد…"
                            maxlength="120"
                            autocomplete="off"
                            aria-describedby="search-hint"
                        >
                        <small id="search-hint" class="form-text text-muted mt-2">
                            اكتب <strong>حرفين على الأقل</strong> (عربي أو إنجليزي)، بعدها اضغط بحث. لو مش متأكد من الإملاء، جرّب حتة صغيرة من الاسم.
                        </small>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <span class="fa fa-search ms-1" aria-hidden="true"></span>
                            بحث في الدليل
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (! $queryReady)
        @if ($qTrim !== '')
            <div class="alert alert-warning border-0 shadow-sm" role="status">
                <strong>لسه بدري على النتائج.</strong>
                لازم على الأقل <strong>حرفين</strong> بعد ما نشيل المسافات الزيادة. جرّب تكتب جزء أوضح من اسم الجامعة أو الكلية.
            </div>
        @else
            <div class="alert alert-info border-0 shadow-sm" role="region" aria-labelledby="search-tips-title">
                <h2 id="search-tips-title" class="h6 fw-bold mb-2">نصايح سريعة قبل ما تبحث</h2>
                <ul class="mb-0 pe-4 ps-0 small">
                    <li class="mb-1">لو عايز تفتح <strong>قائمة كاملة</strong> وتلف بين الصفحات: استخدم <a href="{{ route('universities.index') }}">دليل الجامعات</a> أو <a href="{{ route('colleges.index') }}">كليات ومعاهد مصر</a>.</li>
                    <li class="mb-1">لو عايز تقارن كليتين من ناحية التنسيق: <a href="{{ route('colleges.compare') }}">مقارنة كليات</a>.</li>
                    <li>لو بتفكر في المسار بعد الثانوية: صفحة <a href="{{ route('careers.index') }}">بعد الثانوية</a>.</li>
                </ul>
            </div>

            <h2 class="h6 text-muted fw-bold mt-4 mb-3">روابط سريعة</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('universities.index') }}" class="text-decoration-none text-body">
                        <div class="card h-100 border search-quick-card transition">
                            <div class="card-body">
                                <span class="fa fa-university text-primary fa-lg mb-2 d-block" aria-hidden="true"></span>
                                <h3 class="h6 card-title">دليل الجامعات</h3>
                                <p class="card-text small text-muted mb-0">تصفح كل الجامعات اللي عليها بيانات في الموقع.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('colleges.index') }}" class="text-decoration-none text-body">
                        <div class="card h-100 border search-quick-card transition">
                            <div class="card-body">
                                <span class="fa fa-graduation-cap text-primary fa-lg mb-2 d-block" aria-hidden="true"></span>
                                <h3 class="h6 card-title">كليات ومعاهد مصر</h3>
                                <p class="card-text small text-muted mb-0">جدول كامل بالكليات والمعاهد المرتبطة بالجامعات.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('tansik.coordination_estimate') }}" class="text-decoration-none text-body">
                        <div class="card h-100 border search-quick-card transition">
                            <div class="card-body">
                                <span class="fa fa-line-chart text-primary fa-lg mb-2 d-block" aria-hidden="true"></span>
                                <h3 class="h6 card-title">تقدير تجريبي</h3>
                                <p class="card-text small text-muted mb-0">تجربة بسيطة على درجات التنسيق (مش نفس البحث في الدليل).</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    @elseif (! $hasAnyResult)
        <div class="text-center py-5 px-3 border rounded bg-light">
            <p class="h5 text-muted mb-2">مفيش نتائج مطابقة لـ &laquo;{{ e($qTrim) }}&raquo;</p>
            <p class="text-muted mb-4">جرّب حروف تانية من الاسم، أو شيّك من الإملاء، أو استخدم الدليل الكامل من الروابط تحت.</p>
            <div class="d-flex flex-wrap justify-content-center">
                <a href="{{ route('search.index', ['q' => null]) }}" class="btn btn-outline-primary m-1">صفحة البحث من تاني</a>
                <a href="{{ route('universities.index') }}" class="btn btn-outline-secondary m-1">دليل الجامعات</a>
                <a href="{{ route('colleges.index') }}" class="btn btn-outline-secondary m-1">كليات ومعاهد مصر</a>
            </div>
        </div>
    @else
        <p class="text-muted mb-4" role="status">
            لقينا <strong>{{ $totalHits }}</strong> {{ $totalHits === 1 ? 'نتيجة' : 'نتائج' }}
            @if ($uniCount && $collegeCount)
                ({{ $uniCount }} {{ $uniCount === 1 ? 'جامعة' : 'جامعات' }}، {{ $collegeCount }} {{ $collegeCount === 1 ? 'كلية أو معهد' : 'كليات أو معاهد' }}).
            @elseif ($uniCount)
                في الجامعات.
            @else
                في الكليات والمعاهد.
            @endif
            اضغط على الاسم عشان تفتح الصفحة التفصيلية.
        </p>

        <section class="mb-5" aria-labelledby="search-universities-heading">
            <h2 id="search-universities-heading" class="h5 mb-3">
                <span class="fa fa-university text-primary ms-2" aria-hidden="true"></span>
                الجامعات
            </h2>
            @if ($universities->isEmpty())
                <p class="text-muted border rounded p-3 bg-white mb-0">مفيش جامعات مطابقة في الدليل لهذا البحث. ممكن تلاقي النتيجة تحت «الكليات والمعاهد».</p>
            @else
                <ul class="list-group shadow-sm">
                    @foreach ($universities as $u)
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative">
                            <a href="{{ route('universities.show', $u) }}" class="search-result-link stretched-link text-decoration-none text-break">{{ $u->name }}</a>
                            @if ($u->type)
                                <span class="badge text-bg-light border ms-2" style="z-index: 1">{{ $u->type }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section aria-labelledby="search-colleges-heading">
            <h2 id="search-colleges-heading" class="h5 mb-3">
                <span class="fa fa-graduation-cap text-primary ms-2" aria-hidden="true"></span>
                الكليات والمعاهد
            </h2>
            @if ($colleges->isEmpty())
                <p class="text-muted border rounded p-3 bg-white mb-0">مفيش كليات أو معاهد مطابقة في الدليل لهذا البحث.</p>
            @else
                <ul class="list-group shadow-sm">
                    @foreach ($colleges as $c)
                        <li class="list-group-item">
                            <a href="{{ route('colleges.show', $c) }}" class="search-result-link fw-bold text-decoration-none text-break">{{ $c->name }}</a>
                            @if ($c->university)
                                <div class="small text-muted mt-1">ضمن: {{ $c->university->name }}</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    @endif
@endsection
