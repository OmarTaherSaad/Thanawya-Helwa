@extends('layouts.app')

@section('title','النت مش شغال عندك')
@section('head')
    <script>
        // if (navigator.onLine) {
        //     window.location.href = '/';
        // }
    </script>
@endsection
@section('content')
<div class="jumbotron text-right">
    <h1 class="display-4">أهلًا بيك في موقع ثانوية حلوة</h1>
    <p class="lead">تقدر تستخدم موقعنا حتى لو مش فاتح النت، لكن في بعض الحاجات البسيطة مبنقدرش نعملها من غير النت للأسف.</p>
    <hr class="my-4">
    <p>أول ما يكون النت موجود، هنقدر نشتغل بكامل طاقتنا.</p>
</div>
@endsection
