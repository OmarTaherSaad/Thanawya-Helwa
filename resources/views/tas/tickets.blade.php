@extends('layouts.app')
@section('title','تذاكري')
@section('content')
<div class="row">
    <div class="col-10">
        <h3>جميع التذاكر المُسجلة باسمك</h3>
    </div>
    @if($Tickets->count() > 1)
    <div class="col-2">تحميل كل التذاكر</div>
    @endif
</div>
<div class="row justify-content-center">
    <div class="col-md-10 col-12">
        @forelse ($Tickets as $ticket)
                <div class="card-group row">
                    <div class="card col-6 col-md-4">
                        <img src="{{ route('tas.tickets.image',['ticketSerial' => $ticket->serial]) }}" alt="Ticket no. {{ $ticket->id }}" class="img-fluid">
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
                </div>     
        @empty
            <h3>لا تريد أي تذاكر مُسجلة بإسمك.</h3>
        @endforelse
    </div>
</div>
@endsection