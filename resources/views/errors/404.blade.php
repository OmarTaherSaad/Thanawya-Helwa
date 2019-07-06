@extends('layouts.app')

@section('title',"خطأ")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
            <h2>الصفحة اللي بتحاول توصلها مش موجودة :( اتأكد من اللينك تاني.</h2>
            <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection