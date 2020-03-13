<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start(); ?>
<!doctype html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Keywords" content="thanawya,ثانوية,ثانوية عامة,ثانوية حلوة">
        <meta name="Description" content="Website of Thanawya Helwa Team to help thanawya amma students (high school in Egypt).">

        {{--PWA--}}
        <link rel="manifest" href="{{ Storage::url('manifest.json') }}">
        <meta name="theme-color" content="#E6DCE7">

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title',config('app.name', 'Thanawya Helwa')) | ثانوية حلوة</title>
        {{--Splash Screen--}}
        <link rel="stylesheet" href="{{ asset('css/splash-screen.css') }}">
        {{--Scripts--}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script defer>
            //Load css files
            var tag = document.createElement("link");
            tag.href = "{{ asset('css/app.css') }}";
            tag.setAttribute('rel', 'stylesheet');
            document.getElementsByTagName("head")[0].appendChild(tag);
        </script>
        @yield('head')
        <link rel="icon" href="{{ Storage::url('assets/images/Logo.ico') }}">
        <script data-ad-client="ca-pub-8176502663524074" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>

    <body>
        @include('partials.splash-screen')
        <header class="sticky-top">
            {{--Navbar --}}
            @if (Str::contains(Route::currentRouteName(),'Tansik'))
                @include('partials.navbar-tansik')
            @elseif(Str::contains(Route::currentRouteName(),'tas.'))
                @include('partials.navbar-tas')
            @else
                @include('partials.navbar')
            @endif
        </header>
        <main role="main">
            {{-- Facebook Chat Plugin --}}
            <!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>

            <!-- Your customer chat code -->
            <div class="fb-customerchat" attribution=setup_tool page_id="1050652325008867" theme_color="#6D65AE"
                logged_in_greeting="أهلًا بيك .. تقدر تكتب هنا أي استفسار أو اقتراح وهنرد عليك عن طريق الفيسبوك"
                logged_out_greeting="أهلًا بيك .. تقدر تكتب هنا أي استفسار أو اقتراح وهنرد عليك عن طريق الفيسبوك">
            </div>
            <div class="container-fluid">
                @include('partials.show-alerts')
                {{-- Content --}}
                @yield('content')
            </div>
            {{--AXIOS loading effect--}}
            <div class="modal" id="axiosModal"></div>
        </main>
        {{-- Footer --}}
        @include('partials.footer')

        @yield('scripts')
        {{--Laravel Mix (code splitting)--}}
        {{-- <script src="js/manifest.js"></script>
        <script src="js/vendor.js"></script>
        <script src="js/app.js"></script> --}}
        @include('partials.notification-setup')
    </body>

</html>
