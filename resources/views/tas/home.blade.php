@extends('layouts.app')

@section('title','TA Summit Homepage')
@section('head')
<link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-auto m-1" id="logoContainer">
            <a href="https://www.facebook.com/events/1099430050446914/" target="_blank"
                data-href="{{ Storage::url('assets/images/tas-logo.jpg') }}" class="progressive replace">
                <img src="{{ Storage::url('assets/images/tas-logo-sm.jpg') }}" alt="TA Summit" class="preview">
            </a>
        </div>
    </div>
    @guest
    <div class="row justify-content-center">
        <div class="col-6 col-md-4 text-center mb-1">
            <a type="button" class="btn btn-dark rounded" title="Register to attend the summit"
                href="{{ route('register') }}">
                <h4>التسجيل لحضور القمة</h4>
            </a>
        </div>
        <div class="col-6 col-md-4 text-center mb-1">
            <a type="button" class="btn btn-dark rounded" title="Login to your account" href="{{ route('login') }}">
                <h4>الدخول إلى حسابي</h4>
            </a>
        </div>
    </div>
    @else
    <div class="row justify-content-center">
        <div class="col-6 text-center mb-1">
            @if(Auth::user()->hasTicket())
            <h4>لقد قمت بشراء تذكرة بالفعل! هنكون في انتظارك!</h4>
            <a type="button" class="btn btn-dark rounded" title="Go to TAS homepage" href="{{ route('tas.schedule') }}">
                <h4>جدول اليوم</h4>
            </a>
            @else
            <a type="button" class="btn btn-dark rounded m-1" title="Go to TAS homepage" href="{{ route('tas.buy-ticket-online') }}">
                <h4>شراء تذكرة أونلاين</h4>
            </a>
            <a type="button" class="btn btn-dark rounded m-1" title="Go to TAS homepage" href="{{ route('tas.tickets.register') }}">
                <h4>تسجيل تذكرة تم شراءها بالفعل</h4>
            </a>
            @endif
        </div>
    </div>
    @endguest

@endsection

@section('scripts')
@endsection