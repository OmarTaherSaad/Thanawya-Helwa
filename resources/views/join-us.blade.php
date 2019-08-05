@extends('layouts.app')

@section('title','انضم إلينا')

@section('head')
<script>
    if (!navigator.onLine) {
            window.location.href = '/offline';
        }
</script>
<link rel="stylesheet" href="{{ asset('css/index.css') }}">    
@endsection

@section('content')
<div class="row justify-content-center">
    <iframe id="frame" src="https://docs.google.com/forms/d/e/1FAIpQLScdTVkETdC-V0TqD9dDV7scXGQygqnBKGUWzK4QFXA4bgZxKA/viewform?embedded=true" style="width:90vw;height:70vh">Loading...</iframe>
</div>
@endsection