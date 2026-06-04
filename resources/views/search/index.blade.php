@extends('layouts.app')
@section('title', 'بحث')
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">بحث في الدليل</h1>
    <form method="get" action="{{ route('search.index') }}" class="mb-4">
        <div class="form-inline">
            <input type="search" name="q" value="{{ e($q) }}" class="form-control mr-2" placeholder="اكتب جزءًا من الاسم" minlength="2" maxlength="120">
            <button type="submit" class="btn btn-primary">بحث</button>
        </div>
    </form>
    @if (strlen($q ?? '') < 2)
    <p class="text-muted">أدخل حرفين على الأقل.</p>
    @else
    <h2 class="h5">الجامعات</h2>
    @if ($universities->isEmpty())
    <p class="text-muted">لا نتائج.</p>
    @else
    <ul class="list-group mb-4">
        @foreach ($universities as $u)
        <li class="list-group-item"><a href="{{ route('universities.show', $u) }}">{{ $u->name }}</a></li>
        @endforeach
    </ul>
    @endif
    <h2 class="h5">الكليات والمعاهد</h2>
    @if ($colleges->isEmpty())
    <p class="text-muted">لا نتائج.</p>
    @else
    <ul class="list-group">
        @foreach ($colleges as $c)
        <li class="list-group-item">
            <a href="{{ route('colleges.show', $c) }}">{{ $c->name }}</a>
            @if($c->university)<span class="text-muted"> — {{ $c->university->name }}</span>@endif
        </li>
        @endforeach
    </ul>
    @endif
    @endif
</div>
@endsection
