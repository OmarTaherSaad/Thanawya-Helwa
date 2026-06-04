@extends('layouts.app')
@section('title', 'تقدير تنسيقي تجريبي')
@section('content')
    <h1 class="h3 mb-2">تقدير تنسيقي تجريبي</h1>
    <div class="alert alert-warning border-0 shadow-sm">
        {{ isset($result) ? $result['disclaimer'] : 'هذه الأداة للتوعية فقط؛ لا تُعد تنبؤًا رسميًا ولا تغني عن موقع التنسيق أو المدرسة.' }}
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $err)
        <div>{{ $err }}</div>
        @endforeach
    </div>
    @endif
    <form method="post" action="{{ route('tansik.coordination_estimate.submit') }}" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="college_slug" class="form-label">slug الكلية (من رابط صفحة الكلية)</label>
            <input type="text" class="form-control" id="college_slug" name="college_slug" required
                value="{{ old('college_slug', isset($college) ? $college->slug : '') }}">
        </div>
        <div class="mb-3">
            <label for="section" class="form-label">الشعبة</label>
            <select name="section" id="section" class="form-select">
                <option value="E" {{ old('section', $section ?? 'E') === 'E' ? 'selected' : '' }}>علمي</option>
                <option value="A" {{ old('section', $section ?? 'E') === 'A' ? 'selected' : '' }}>أدبي</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">احسب تقديرًا تجريبيًا</button>
    </form>
    @isset($result)
    @if ($result['estimate'] === null)
    <p class="text-muted">لا يوجد تقدير رقمي كافٍ.</p>
    @else
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><strong>التقدير التجريبي:</strong> {{ $result['estimate'] }}</p>
            @php
                $points = $result['payload']['points'] ?? [];
            @endphp
            @if (! empty($points))
            <p><strong>النقاط (سنة — حد):</strong>
                {{ collect($points)->map(fn ($p) => ($p['year'] ?? '?').' — '.($p['edge'] ?? '?'))->implode('، ') }}
            </p>
            @endif
            <p class="small text-muted">طريقة الحساب: {{ $result['method'] }}</p>
        </div>
    </div>
    @endif
    @endisset
@endsection
