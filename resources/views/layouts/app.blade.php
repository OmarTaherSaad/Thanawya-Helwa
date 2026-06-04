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
        @php
            use Artesaos\SEOTools\Facades\JsonLdMulti;
            use Artesaos\SEOTools\Facades\OpenGraph;
            use Artesaos\SEOTools\Facades\SEOMeta;
            use Artesaos\SEOTools\Facades\TwitterCard;

            $metaTitle = SEOMeta::getTitle();
            if (($metaTitle === false || $metaTitle === null || $metaTitle === '') && isset($__env) && $__env->hasSection('title')) {
                $t = trim(strip_tags($__env->yieldContent('title')));
                if ($t !== '') {
                    $full = $t.' | ثانوية حلوة';
                    SEOMeta::setTitle($full, false);
                    OpenGraph::setTitle($full);
                    TwitterCard::setTitle($full);
                    JsonLdMulti::select(0)->setTitle($full);
                    $desc = SEOMeta::getDescription();
                    if (is_string($desc) && $desc !== '') {
                        JsonLdMulti::setDescription($desc);
                    }
                }
            }
        @endphp
        {{-- Minified SEO Tags (includes single <title> from SEOMeta) --}}
        {!! SEO::generate(true) !!}
        @stack('jsonld')
        @laravelPWA        

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Facebook Domain Verification --}}
        <meta name="facebook-domain-verification" content="jp9e6kb63rdhvbfwsxx8loghehmn4c" />
        {{--Splash Screen--}}
        <link rel="stylesheet" href="{{ mix('css/splash-screen.css') }}">
        {{--Scripts (moved to end of <body> so DOM exists before Bootstrap/jQuery run) --}}
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
        @if (config('ads.enabled') && ! Route::currentRouteNamed('home') && filled(config('ads.adsense_client')))
            <link rel="dns-prefetch" href="https://pagead2.googlesyndication.com">
            <link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>
            <script async
                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ rawurlencode(config('ads.adsense_client')) }}"
                crossorigin="anonymous"></script>
        @endif
        <link rel="icon" href="{{ Storage::url('assets/images/Logo.ico') }}">
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
    </head>
    <body>
        {{-- Splash Screen --}}
        @include('partials.splash-screen')
        {{-- Wrapper: single flex child that grows so footer stays at viewport bottom on short pages --}}
        <div class="th-site">
            @include('partials.navbar')
            {{-- Stacked min-height ad slots before <main> push the homepage hero down; reserve them on inner pages only. --}}
            @if (config('ads.enabled') && ! Route::currentRouteNamed('home') && filled(config('ads.adsense_client')))
                @include('partials.adsense-slots')
            @endif

            <main role="main">
                @if(Route::currentRouteNamed('home'))
                <div class="container-fluid px-0">
                @else
                {{-- Single .container here; inner views must not nest another .container (avoids double padding / crooked alignment). --}}
                <div class="container th-page-gutter">
                @endif
                    @include('partials.show-alerts')
                    {{-- Content --}}
                    @yield('content')
                </div>
                {{--AXIOS loading effect--}}
                <div class="modal" id="axiosModal"></div>
            </main>
        </div>
        @include('partials.footer')
        @include('partials.notification-setup')
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('styles')
        @stack('adsense-push')
        @yield('scripts')
    </body>
</html>
