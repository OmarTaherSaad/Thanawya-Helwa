@extends('layouts.app')
@section('title', 'مسارات بعد الثانوية العامة')
@section('content')
    <h1 class="h3 mb-3">مسارات بعد الثانوية العامة</h1>
    <p class="lead">ثانوية حلوة تجمع أدوات تساعدك في مرحلة التنسيق والتحضير — من غير ما نكرر محتوى الجهات الرسمية.</p>
    <ul class="list-group mb-4">
        <li class="list-group-item">
            <a href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a> — جداول الحد الأدنى لكليات ومعاهد مصر.
        </li>
        <li class="list-group-item">
            <a href="{{ route('colleges.index') }}">كليات ومعاهد مصر</a> — دليل صفحات الكليات المرتبطة بالبيانات.
        </li>
        <li class="list-group-item">
            <a href="{{ route('universities.index') }}">الجامعات</a> — عرض الجامعات وكلياتها في الدليل.
        </li>
        <li class="list-group-item">
            <a href="{{ route('colleges.compare') }}">مقارنة كليات</a> — مقارنة الحد الأدنى بين أكثر من كلية (شعبة واحدة).
        </li>
        <li class="list-group-item">
            <a href="{{ route('tansik.coordination_estimate') }}">تقدير تنسيقي تجريبي</a> — أداة توعية غير رسمية (مع تنبيه واضح).
        </li>
        <li class="list-group-item">
            <a href="{{ route('quiz.index') }}">اختبارات تدريبية</a> — كويزات الفريق.
        </li>
        <li class="list-group-item">
            <a href="{{ route('ministryExam.index') }}">امتحانات الوزارة</a> — أرشيف الملفات المتاحة.
        </li>
        <li class="list-group-item">
            <a href="{{ route('join-us') }}">انضم للفريق</a>
        </li>
    </ul>
    <p class="text-muted">للمحتوى التفصيلي والمقالات: <a href="https://blog.thanawyahelwa.org" rel="noopener" target="_blank">مدونة ثانوية حلوة</a>.</p>
@endsection
