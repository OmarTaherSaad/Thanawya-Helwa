<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start(); ?>
<!doctype html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Keywords" content="thanawya,ثانوية,ثانوية عامة,ثانوية حلوة">
        <meta name="Description"
            content="Website of Thanawya Helwa Team to help thanawya amma students (high school in Egypt).">

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

        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
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
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" type="text/javascript"></script>
    </head>

    <body>
        {{-- Splash Screen --}}
        @include('partials.splash-screen')
        @include('partials.navbar')
        <main role="main ">
            @if(Route::currentRouteNamed('home'))
            <div class="container-fluid px-0">
            @else
            <div class="container px-0">
            @endif
                @include('partials.show-alerts')
                {{-- Content --}}
                @yield('content')
            </div>
            {{--AXIOS loading effect--}}
            <div class="modal" id="axiosModal"></div>
        </main>
        @include('partials.footer')
        @include('partials.notification-setup')
        <script src="{{ asset('js/effects.js') }}" sync></script>
        @yield('scripts')
    </body>
</html>
