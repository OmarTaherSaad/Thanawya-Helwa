@php
if(array_key_exists('HTTP_ACCEPT_ENCODING',$_SERVER)) {
    if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
        ob_start('ob_gzhandler');
    else
        ob_start();
}
@endphp
<!doctype html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- Minified SEO Tags --}}
        {!! SEO::generate(true) !!}
        @laravelPWA        

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Facebook Domain Verification --}}
        <meta name="facebook-domain-verification" content="jp9e6kb63rdhvbfwsxx8loghehmn4c" />

        <title>@yield('title',config('app.name', 'Thanawya Helwa')) | ثانوية حلوة</title>
        {{--Splash Screen--}}
        <link rel="stylesheet" href="{{ mix('css/splash-screen.css') }}">
        {{--Scripts--}}
        <script src="{{ mix('js/app.js') }}"></script>
        <link rel="preload" href="/webfonts/fa-solid-900.woff2">
        <link rel="preload" href="/webfonts/fa-brands-400.woff2">
        {{-- Google Font --}}
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
        <script defer>
            //Load css files
            var tag = document.createElement("link");
            tag.href = "{{ mix('css/app.css') }}";
            tag.setAttribute('rel', 'stylesheet');
            document.getElementsByTagName("head")[0].appendChild(tag);
            tag = document.createElement("link");
            tag.href = "{{ mix('css/fontawesome.css') }}";
            tag.setAttribute('rel', 'stylesheet');
            document.getElementsByTagName("head")[0].appendChild(tag);
        </script>
        @yield('head')
        <link rel="icon" href="{{ Storage::url('assets/images/Logo.ico') }}">
    </head>
    <body>
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
        @yield('scripts')
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '286189226340899');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=286189226340899&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    </body>
</html>
