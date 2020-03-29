@extends('layouts.app')

@section('title','TA Summit Countdown')
@section('head')
<link rel="stylesheet" href="{{ asset('css/event.css') }}">
@endsection
@section('content')
<!-- 2018-03-02 23:59:00 -->
<!-- "Y-m-d H:i:s" -->
<div id="app">
    <div class="row justify-content-center">
        <div class="col-auto m-1" id="logoContainer">
            <a href="https://www.facebook.com/events/1099430050446914/" target="_blank">
                <img src="{{ Storage::url('assets/images/tas-logo.jpg') }}" alt="TA Summit">
            </a>
        </div>
    </div>
    @guest
        <div class="row justify-content-center">
            <div class="col-6 col-md-4 text-center mb-1">
                <a type="button" class="btn btn-dark rounded" title="Register to attend the summit" href="{{ route('register') }}">
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
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="countdown row">
                <div class="col-6  col-md-3">
                    <h1 class="digit" id="seconds"></h1>
                    <h1 class="text">ثواني</h1>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="digit" id="minutes"></h1>
                    <h1 class="text">دقائق</h1>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="digit" id="hours"></h1>
                    <h1 class="text">ساعات</h1>
                </div>
                <div class="col-6 col-md-3">
                    <h1 class="digit" id="days"></h1>
                    <h1 class="text">أيام</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function formatText(value) {
            if (value < 0) {
                return '00';
            }
            if (value.toString().length <= 1) {
                return `0${value}`;
            }
            return value;
        }
        var countDownDate = new Date("Aug 23, 2019 10:00:00").getTime();
        //Initial
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        document.getElementById("seconds").innerHTML = formatText(seconds);
        document.getElementById("minutes").innerHTML = formatText(minutes);
        document.getElementById("hours").innerHTML = formatText(hours);
        document.getElementById("days").innerHTML = formatText(days);
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("seconds").innerHTML = formatText(seconds);
            if (seconds == 59) { //Changing dependants
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById("minutes").innerHTML = formatText(minutes);
                if (minutes == 59) { //Changing dependants
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    document.getElementById("hours").innerHTML = formatText(hours);
                    if (hours == 23) { //Changing dependants
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        document.getElementById("days").innerHTML = formatText(days);
                    }
                }
            }

            // If the count down is finished, Do something
            if (distance < 0) {
                clearInterval(x);
                //Action to do
            }
        }, 1000);
    </script>
@endsection
