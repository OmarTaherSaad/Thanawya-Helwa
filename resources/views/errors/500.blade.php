@extends('layouts.app')

@section('title',"خطأ 500 | Server Error")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        <h2>هناك خطأ في السيرفر، برجاء المحاولة في وقتٍ آخر.</h2>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection