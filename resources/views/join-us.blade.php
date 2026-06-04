@extends('layouts.app')

@section('title','انضم إلينا')

@section('head')
<script>
    if (!navigator.onLine) {
            window.location.href = '/offline';
        }
</script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-4 p-md-5 text-center">
                <h1 class="h3 mb-3">انضم لفريق ثانوية حلوة</h1>
                <p class="text-muted mb-4 text-start">
                    لو حابب تساهم في دعم طلبة الثانوية العامة (محتوى، تنسيق، فعاليات، أو غيره)، املأ استمارة التطوع
                    على جوجل فورمز من الرابط تحت. هنراجع الطلبات ونرجع لك على قد ما نقدر.
                </p>
                <a href="https://forms.gle/MNfd5AgtKMuBFJ9X8" class="btn btn-primary btn-lg px-5" rel="noopener noreferrer" target="_blank">
                    فتح استمارة الانضمام
                </a>
                <p class="small text-muted mt-4 mb-0">
                    الرابط بيفتح في تاب جديد. لو عندك مشكلة في الفتح، جرّب من متصفح تاني أو من الموبايل.
                </p>
            </div>
        </div>
        <p class="text-center mt-4">
            <a href="{{ route('about-us') }}" class="text-decoration-none">تعرف على الفريق</a>
            <span class="text-muted mx-2" aria-hidden="true">·</span>
            <a href="{{ route('contact') }}" class="text-decoration-none">تواصل معنا</a>
        </p>
    </div>
</div>
@endsection
