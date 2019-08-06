@extends('layouts.app')
@section('title','Event Entry Check')
@section('content')
<div id="edgesApp">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">الدخول على بوابة القمة</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-3 m-2">
                            <qrcode-stream @decode="ValidateQR"></qrcode-stream>
                        </div>
                        <div class="col" v-if="ticket != null">
                            <div v-bind:class="{'bg-success': ticket.paid, 'bg-warning': !ticket.paid}">
                                Ticket Owner: @{{ ticket_owner ? ticket_owner.name : 'No owner registered' }}
                                <hr>
                                Ticket Type: @{{ ticket.type }}
                                <hr>
                                Ticket is @{{ !ticket.paid ? 'not' : '' }} paid
                                <hr>
                                Ticket Owner Mobile Number: @{{ ticket_owner ? ticket_owner.mobile_number : 'No owner registered' }}
                                <hr>
                                Ticket Number: @{{ ticket.id }}
                                <hr>
                                Ticket Serial: @{{ ticket_serial }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/ticketsScan.js') }}"></script>
@endsection