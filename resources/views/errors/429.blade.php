@extends('layouts.app')

@section('title',"خطأ 429 | Too Many Requests")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        <h2>لقد قمت بالعديد من الطلبات في آنٍ واحد.</h2>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection