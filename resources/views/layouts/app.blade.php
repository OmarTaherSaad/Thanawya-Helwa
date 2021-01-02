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

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title',config('app.name', 'Thanawya Helwa')) | ثانوية حلوة</title>
        {{--Splash Screen--}}
        <link rel="preload" href="{{ mix('css/splash-screen.css') }}" as="style">
        {{--Scripts--}}
        <script src="{{ mix('js/app.js') }}"></script>
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
        <script src="{{ mix('js/effects.js') }}" defer></script>
        @yield('scripts')
    </body>
</html>
