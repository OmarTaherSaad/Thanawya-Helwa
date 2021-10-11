@extends('layouts.app')
@section('title','تذاكري')
@section('content')
{{--Admin can see all tickets--}}
@if(Auth::user()->isAdmin())
<div class="row">
    <div class="col-12 m3">
        <h2>جميع الأرقام الخاصة بالتذاكر</h2>
    </div>
    <div class="col-12">
        <h5 class="border bg-primary my-1 p-2">عدد التذاكر المُسجلة: {{ $AllTickets->count() }}</h5>
    </div>
    <div class="col-12 col-md-6">
        <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من "إبداع": {{ $AllTickets->where('payment_method','offline-Ebda3')->count() }}</h5>
    </div>
    <div class="col-12 col-md-6">
        <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من أعضاء الفريق: {{ $AllTickets->where('payment_method','offline-Team-members')->count() }}</h5>
    </div>
    <div class="col-12 col-md-6">
        <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من فودافون كاش: {{ $AllTickets->where('payment_method','online-Vodafone-cash')->count() }}</h5>
    </div>
    <div class="col-12 col-md-6">
        <h5 class="border bg-dark text-white my-1 p-2">عدد التذاكر المُسجلة ومُباعة من اتصالات فلوس: {{ $AllTickets->where('payment_method','online-Etisalat-cash')->count() }}</h5>
    </div>
</div>
<hr>
@endif
<div class="row">
    <div class="col-10">
        <h3>جميع التذاكر المُسجلة باسمك (عددهم {{ $Tickets->count() }})</h3>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-10 col-12">
        <div class="row">
        @forelse ($Tickets as $ticket)
            <div class="border border-dark col-12 col-md-4 p-1 m-1">
                <img src="{{ Storage::url('assets/blank.gif') }}" data-src="{{ route('tas.tickets.image',['ticketSerial' => $ticket->serial]) }}" alt="Ticket no. {{ $ticket->id }}" class="lazyload img-fluid">
                <div class="card-body">
                    <h5 class="card-title">تذكرة {{ $ticket->type == 'student' ? 'طلبة' : 'أولياء أمور' }}</h5>
                    <p class="card-text">
                        @if($ticket->hasPayment())
                        تم دفعها عن طريق {{ $ticket->payment->first()->method() }}
                        @endif
                        <a href="{{ route('tas.tickets.download',['ticketSerial' => $ticket->serial]) }}">تحميل التذكرة</a>
                    </p>
                    <p class="card-text"><small class="text-muted">تم تسجيلها {{ $ticket->updated_at->diffForHumans() }}</small></p>
                </div>
            </div>
        @empty
            <h3>لا توجد أي تذاكر مُسجلة بإسمك.</h3>
        @endforelse
        </div>     
    </div>
</div>

{{--Admin can see all tickets--}}
@if(Auth::user()->isAdmin())
<hr>
<div class="row">
    <div class="col-10">
        <h3>جميع التذاكر المُسجلة (عددهم {{ $AllTickets->count() }})</h3>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-10 col-12">
        <div class="row">
            @forelse ($AllTickets as $ticket)
            <div class="border border-dark col-12 col-md-4 p-1 m-1">
                <img src="{{ Storage::url('assets/blank.gif') }}" data-src="{{ route('tas.tickets.image',['ticketSerial' => $ticket->serial]) }}"
                    alt="Ticket no. {{ $ticket->id }}" class="lazyload img-fluid">
                <div class="card-body">
                    <h5 class="card-title">تذكرة {{ $ticket->type == 'student' ? 'طلبة' : 'أولياء أمور' }}</h5>
                    <p class="card-text">
                        @if($ticket->hasPayment())
                        تم دفعها عن طريق {{ $ticket->payment->first()->method() }}
                        @endif
                        <a href="{{ route('tas.tickets.download',['ticketSerial' => $ticket->serial]) }}">تحميل
                            التذكرة</a>
                        <hr>
                        صاحب التذكرة: {{ $ticket->ownerName() }}
                    </p>
                    <p class="card-text"><small class="text-muted">تم تسجيلها
                            {{ $ticket->updated_at->diffForHumans() }}</small></p>
                </div>
            </div>
            @empty
        </div>
        <h3>لا تريد أي تذاكر مُسجلة.</h3>
        @endforelse
    </div>
</div>
@endif
@endsection