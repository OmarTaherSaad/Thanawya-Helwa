<!doctype html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Keywords" content="thanawya,ثانوية,ثانوية عامة,ثانوية حلوة">
        <meta name="Description" content="Website of Thanawya Helwa Team to help thanawya amma students (high school in Egypt).">
        
        {{--PWA--}}
        <link rel="manifest" href="{{ Storage::url('manifest.json') }}">
        <meta name="theme-color" content="#E4E4E4">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title',config('app.name', 'Thanawya Helwa')) | ثانوية حلوة</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/splash-screen.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" async></script>
        <script defer>
            let func = function() {
                //Load additional scripts after page loads
                src = new Array(2);
                src[0] = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
                src.forEach(s => {
                    var tag = document.createElement("script");
                    tag.src = s;
                    document.getElementsByTagName("head")[0].appendChild(tag);
                });
                //Load css files
                src = new Array(3);
                src[0] = "{{ asset('css/app.css') }}";
                src.forEach(s => {
                    var tag = document.createElement("link");
                    tag.href = s;
                    tag.setAttribute('rel','stylesheet');
                    document.getElementsByTagName("head")[0].appendChild(tag);
                });
                window.fbAsyncInit = function() {
                    FB.init({
                        xfbml : true,
                        version : 'v3.3'
                    });
                };
                
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = 'https://connect.facebook.net/ar_AR/sdk/xfbml.customerchat.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            }
            if (window.addEventListener) {
                window.addEventListener('load',func);
            } else {
                window.attachEvent('onload',func);
            }

            if ('serviceWorker' in navigator ) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                        // Registration was successful
                    }, function(err) {
                        // registration failed :(
                    });
                });
            }
        </script>
        @yield('head')
        <link rel="icon" href="{{ Storage::url('assets/images/logo.ico') }}">
        <!--Google Auto-Ads-->
        <script defer>
            (adsbygoogle = window.adsbygoogle || []).push({
                  google_ad_client: "ca-pub-8176502663524074",
                  enable_page_level_ads: true
             });
        </script>
    </head>

    <body>
        <div id="wrapper">
            {{-- Facebook Chat Plugin --}}
            <!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>

            <!-- Your customer chat code -->
            <div class="fb-customerchat" attribution=setup_tool page_id="1050652325008867" theme_color="#6D65AE"
                logged_in_greeting="أهلًا بيك .. تقدر تكتب هنا أي استفسار أو اقتراح وهنرد عليك عن طريق الفيسبوك"
                logged_out_greeting="أهلًا بيك .. تقدر تكتب هنا أي استفسار أو اقتراح وهنرد عليك عن طريق الفيسبوك">
            </div>

            {{--Navbar --}}
            @include('partials.splash-screen')
            @if (Str::contains(Route::currentRouteName(),'Tansik'))
            @include('partials.navbar-tansik')
            @else
            @include('partials.navbar')
            @endif

            <div class="container-fluid">
                @include('partials.show-alerts')
                {{-- Content --}}
                @yield('content')
            </div>
            {{-- Footer --}}
        </div>
        @include('partials.footer')
        {{--AXIOS loading effect--}}
        <div class="modal" id="axiosModal"></div>

        @yield('scripts')
    </body>

</html>