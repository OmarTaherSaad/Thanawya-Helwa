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
    <div class="col 10 text-center">
        <h2>استمارة الانضمام لينا</h2>
        <a href="https://forms.gle/MNfd5AgtKMuBFJ9X8" class="btn btn-primary">اضغط هنا</a>
    </div>
</div>
@endsection
