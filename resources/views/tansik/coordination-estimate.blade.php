@extends('layouts.app')
@section('title', 'تقدير تنسيقي تجريبي')
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-2">تقدير تنسيقي تجريبي</h1>
    <div class="alert alert-warning">
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
        <div class="form-group">
            <label for="college_slug">slug الكلية (من رابط صفحة الكلية)</label>
            <input type="text" class="form-control" id="college_slug" name="college_slug" required
                value="{{ old('college_slug', isset($college) ? $college->slug : '') }}">
        </div>
        <div class="form-group">
            <label for="section">الشعبة</label>
            <select name="section" id="section" class="form-control">
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
    <div class="card">
        <div class="card-body">
            <p><strong>التقدير (متوسط آخر سنوات مسجلة):</strong> {{ $result['estimate'] }}</p>
            <p><strong>السنوات المستخدمة:</strong> {{ implode('، ', $result['years_used']) }}</p>
            <p class="small text-muted">طريقة الحساب: {{ $result['method'] }}</p>
        </div>
    </div>
    @endif
    @endisset
</div>
@endsection
