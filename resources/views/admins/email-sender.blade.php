@extends('layouts.app')
@section('title','Email Sender')
@section('head')
<link rel="stylesheet" href="{{ mix('css/texteditor.css') }}" />
@endsection
@section('content')
<div id="app" class="m-2">
    <div class="row mt-2">
        <div class="col-12 my-2" v-if="alerts !== null">
            <div v-bind:class="{'alert-success alert fade show': alerts, 'alert-danger alert fade show': !alerts}"
                role="alert">
                <ul>
                    <li v-if="Array.isArray(alertsList)" v-for="alert in alertsList">
                        <span v-for="miniAlert in alert">@{{ miniAlert }}<br></span>
                    </li>
                    <li v-if="!Array.isArray(alertsList)" v-for="alert in alertsList">@{{ alert }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>TH Email Sender</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <form action="{{ route('admins.email-sender-action') }}" method="post" v-on:submit.prevent="sendMails"
                id="submitForm">
                @csrf
                <div class="form-group">
                    <label for="emails">Emails (Comma-Separated Values)</label>
                    <textarea class="form-control" name="emails" id="emails" v-model="emails" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" v-model="mail_subject" class="form-control">
                </div>

                <div class="form-group">
                    <textarea id="textEditor" name="description" v-model="mail_body"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Send Mail(s)</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/email-sender.js') }}"></script>
<script src="{{ asset('texteditor/ckeditor.js') }}"></script>
<script defer>
    CKEDITOR.replace('textEditor', {});
    window.vueApp.$data.submitURL = $("#submitForm").attr('action');
</script>
@endsection
