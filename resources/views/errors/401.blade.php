@extends('layouts.app')

@section('title',"خطأ 401 | Unauthorized")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        <h2>أنت غير مسموح لك بالدخول إلى هذه الصفحة</h2>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection