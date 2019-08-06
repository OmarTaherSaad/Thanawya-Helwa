@extends('layouts.app')

@section('title',"خطأ 403 | Forbidden")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        {{ $exception->getMessage() }}
        <h2>أنت غير مُصرح لك بالدخول إلى هذه الصفحة.</h2>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection