@extends('layouts.app')

@section('title',"خطأ 419 | Page Expired")

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 text-center">
        <h2>الصفحة التي حاولت الوصول إليها صفحة منتهية.</h2>
        <a class="btn btn-primary" href="{{ route('home') }}" role="button">الرئيسية</a>
    </div>
</div>
@endsection