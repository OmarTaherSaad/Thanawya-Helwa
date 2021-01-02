@extends('layouts.app')
@section('title','Event Entry Check')
@section('content')
<div id="edgesApp">
    <div class="row m-2">
        <h3>الدخول على بوابة القمة</h3>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <qrcode-stream @decode="ValidateQR" :camera="camera">
                <b>Try to center the QR on ticket</b>
            </qrcode-stream>
        </div>
        <div class="col-12 col-md-6 text-left" v-if="ticket != null">
            <div v-bind:class="{'bg-success': ticket.paid, 'bg-warning': !ticket.paid}">
                Ticket Owner: @{{ ticket_owner ? ticket_owner.name : 'No owner registered' }}
                <hr>
                Ticket is @{{ !ticket.paid ? 'not' : '' }} paid
                <hr>
                Ticket Type: @{{ ticket.type }}
                <hr>
                Ticket Owner Mobile Number: @{{ ticket_owner ? ticket_owner.mobile_number : 'No owner registered' }}
                <hr>
                Ticket Number: @{{ ticket.id }}
                <hr>
                Ticket Serial: @{{ ticket_serial }}
            </div>
            <button class="btn btn-success" @click="Entered">تم الدخول</button>
            <button class="btn btn-success" @click="Cancelled">إلغاء</button>
            <div v-if="register.message != null" role="alert" v-bind:class="register.success" v-html="register.message">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ mix('js/ticketsScan.js') }}"></script>
@endsection