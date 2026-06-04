@extends('layouts.app')
@section('title', 'مقارنة كليات')
@section('content')
@php
    $colleges = $comparison['colleges'] ?? collect();
    $years = $comparison['years'] ?? collect();
    $matrix = $comparison['matrix'] ?? [];
    $sec = $comparison['section'] ?? $section;
@endphp
<div class="container py-4">
    <h1 class="h3 mb-3">مقارنة الحد الأدنى بين كليات</h1>
    <p class="text-muted">أدخل روابط أو معرفات slug لكليات (من عنوان صفحة الكلية)، مفصولة بفواصل، حتى ٥ كليات. الشعبة: علمي أو أدبي.</p>
    <form method="get" action="{{ route('colleges.compare') }}" class="mb-4">
        <div class="form-group">
            <label for="slugs">سلسلة الـ slugs (مثال: college-12,college-34)</label>
            <input type="text" class="form-control" id="slugs" name="slugs" value="{{ e($slugsInput) }}" placeholder="college-1,college-2">
        </div>
        <div class="form-group">
            <label for="section">الشعبة</label>
            <select name="section" id="section" class="form-control">
                <option value="E" {{ $sec === 'E' ? 'selected' : '' }}>علمي</option>
                <option value="A" {{ $sec === 'A' ? 'selected' : '' }}>أدبي</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">عرض المقارنة</button>
    </form>
    @if ($colleges->count() < 2)
    <div class="alert alert-info">أدخل slugين على الأقل من صفحات الكليات النشطة لعرض الجدول.</div>
    @elseif ($years->isEmpty())
    <div class="alert alert-warning">لا توجد سنوات تنسيق مسجلة لهذه الكليات في الشعبة المختارة.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>الكلية</th>
                    @foreach ($years as $year)
                    <th>{{ $year }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($colleges as $college)
                <tr>
                    <td class="text-right">
                        <a href="{{ route('colleges.show', $college) }}">{{ $college->name }}</a>
                    </td>
                    @foreach ($years as $year)
                    @php $cell = $matrix[$college->id][$year] ?? null; @endphp
                    <td>{{ $cell === null ? '—' : $cell }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
