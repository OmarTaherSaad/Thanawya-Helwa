@extends('layouts.app')

@section('title','جدول اليوم | TAS')

@section('head')
<link rel="stylesheet" href="{{ mix('css/fontawesome.css') }}">
<style>
    html {
        font-size: 1.2em !important;
    }
</style>
@endsection

@section('content')
<div id="users-device-size">
    <div id="bigScreen" class="d-none d-md-block"></div>
    <div id="smallScreen" class="d-sm-none"></div>
</div>
<div id="app">
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>قمة الثانوية العامة - جدول اليوم</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <v-timeline :dense="display">
                <v-timeline-item v-for="item in items" color="red lighten-2" :fill-dot="display" :large="!display" :small="display" dir="ltr">
                    <template v-slot:icon>
                        <i class="fas fa-clock"></i>
                    </template>
                    <span slot="opposite">@{{ item.time }}</span>
                    <div class="card" dir="rtl">
                        <div class="card-body">
                            <h6 class="text-muted d-md-none" dir="ltr">@{{ item.time }}</h6>
                            <h5 class="card-title">@{{ item.title }}</h5>
                            <p class="card-text">@{{ item.desc }}</p>
                        </div>
                    </div>
                </v-timeline-item>
            </v-timeline>
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
        <div class="col-6 col-md-4 text-center mb-1">
            <a type="button" class="btn btn-dark rounded" title="Go to TAS homepage" href="{{ route('tas.home') }}">
                <h4>الصفحة الرئيسية لقمة الثانوية العامة</h4>
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection
@section('scripts')
<script src="{{ mix('js/tas-schedule.js') }}"></script>
@endsection