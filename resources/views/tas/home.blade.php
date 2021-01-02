@extends('layouts.app')

@section('title','TA Summit Homepage')
@section('head')
<link rel="stylesheet" href="{{ mix('css/event.css') }}">
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-auto m-1" id="logoContainer">
            <a href="https://www.facebook.com/events/1099430050446914/" target="_blank">
                <img src="{{ Storage::url('assets/images/tas-logo-sm.jpg') }}" alt="TA Summit">
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
            <a type="button" class="btn btn-dark rounded" title="Go to TAS schedule" href="{{ route('tas.schedule') }}">
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

    {{--Admin can see all tickets--}}
    @if(Auth::user()->isAdmin())
    <div class="row">
        <div class="col-12 m3">
            <h2>جميع الأرقام الخاصة بالقمة</h2>
        </div>
        <div class="col-12">
            <h5 class="border bg-primary my-1 p-2">عدد التذاكر المُسجلة: {{ \App\Ticket::whereNotNull('payment_method')->count() }}</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من "إبداع":
                {{ \App\Ticket::where('payment_method','offline-Ebda3')->count() }}</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من أعضاء الفريق:
                {{ \App\Ticket::where('payment_method','offline-Team-members')->count() }}</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من فودافون كاش:
                {{ \App\Ticket::where('payment_method','online-Vodafone-cash')->count() }}</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من اتصالات فلوس:
                {{ \App\Ticket::where('payment_method','online-Etisalat-cash')->count() }}</h5>
        </div>
        <hr>
        <div class="col-12">
            <h5 class="border bg-primary my-1 p-2">إجمالي الفلوس المدفوعة: {{ \App\Payment::all()->sum('amount') }} جنية
            </h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">إجمالي الفلوس المدفوعة من "إبداع":
                {{ \App\Payment::all()->where('method','offline-Ebda3')->sum('amount') }} جنية</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">إجمالي الفلوس المدفوعة من أعضاء الفريق:
                {{ \App\Payment::all()->where('method','offline-Team-members')->sum('amount') }} جنية</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">إجمالي الفلوس المدفوعة من فودافون كاش:
                {{ \App\Payment::all()->where('method','online-Vodafone-cash')->sum('amount') }} جنية</h5>
        </div>
        <div class="col-12 col-md-6">
            <h5 class="border bg-dark text-white my-1 p-2">إجمالي الفلوس المدفوعة من اتصالات فلوس:
                {{ \App\Payment::all()->where('method','online-Etisalat-cash')->sum('amount') }} جنية</h5>
        </div>
    </div>
    <hr>
    @endif
    @endguest

@endsection

@section('scripts')
@endsection
