@extends('layouts.app')

@section('title',"خطأ 503 | Service Unavailable")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        <h2>هذه الخدمة غير متاحة</h2>
        <h3>نقوم ببعض التطويرات الآن، سيكون الموقع متاح خلال دقائق/ساعات قليلة.</h3>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection
