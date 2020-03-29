<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start(); ?>
<!doctype html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- Minified SEO Tags --}}
        {!! SEO::generate(true) !!}

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
        {{-- Facebook Chat Plugin START--}}
        @if (!auth()->check() || !auth()->user()->isTeamMember())
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                xfbml  : true,
                version: 'v6.0'
                });
            };

            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/ar_AR/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <!-- Your customer chat code -->
        <div class="fb-customerchat" attribution=setup_tool page_id="1050652325008867" theme_color="#fa3c4c"
            logged_in_greeting="أهلًاّ تقدر تكلمنا من هنا وهنتشرف بالرد عليك ^_^"
            logged_out_greeting="أهلًاّ تقدر تكلمنا من هنا وهنتشرف بالرد عليك ^_^">
        </div>
        @endif
        {{-- Facebook Chat Plugin END--}}
        {{-- Splash Screen --}}
        @include('partials.splash-screen')
        @include('partials.navbar')

        <main role="main ">
            @if(Route::currentRouteNamed('home'))
            <div class="container-fluid px-0">
            @else
            <div class="container">
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
