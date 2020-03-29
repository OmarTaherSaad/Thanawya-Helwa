@extends('layouts.app')
@section('title',"عرض الامتحانات | " . $MinistryExam->title)
@section('head')
    <style>
        canvas {
            background-color: blue;
            width: 100%;
            height: auto;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row my-1">
            <div class="col-12 col-md-auto">
                <a href="{{ route('ministryExam.index') }}" class="btn btn-primary"><i
                        class="fas fa-arrow-alt-circle-right"></i>&nbsp; جميع الامتحانات</a>
            </div>
        </div>
        <section class="bg-gradient">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-8">
                    <h3>{{ $MinistryExam->title }}</h3>
                    <h4>{{ $MinistryExam->subject_name }}</h4>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-8">
                    <a href="{{ route('ministryExam.download',['ministryExam' => $MinistryExam]) }}"><h5 class="btn btn-secondary">تحميل النموذج</h5></a>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-md-8 my-2 text-center" style="height: 85vh;">
                    <object data='{{ Storage::url($MinistryExam->link) }}' class="h-100 w-100">
                        <h3>المتصفح بتاعك مش بيدعم عرض ملفات الPDF! بس مفيش مشكلة، تقدر تحمل النموذج</h3>
                        <a href="{{ route('ministryExam.download',['ministryExam' => $MinistryExam]) }}">
                            <h4 class="btn btn-secondary">تحميل النموذج</h4>
                        </a>
                    </object>
                </div>
            </div>
        </section>
</div>
@endsection
