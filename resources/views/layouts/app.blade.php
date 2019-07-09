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
        <link rel="stylesheet" href="{{ mix('css/splash-screen.css') }}">
        {{--Scripts--}}
        <script src="{{ mix('js/app.js') }}" defer></script>
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
                src[0] = "{{ mix('css/app.css') }}";
                src.forEach(s => {
                    var tag = document.createElement("link");
                    tag.href = s;
                    tag.setAttribute('rel','stylesheet');
                    document.getElementsByTagName("head")[0].appendChild(tag);
                });
                //Facebook Messenger Plugin
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
                //PWA Notifications
                function askPermission() {
                    return new Promise(function(resolve, reject) {
                        const permissionResult = Notification.requestPermission(function(result) {
                        resolve(result);
                        });

                        if (permissionResult) {
                        permissionResult.then(resolve, reject);
                        }
                    })
                    .then(function(permissionResult) {
                        if (permissionResult == 'granted') {
                            //Subscribe user to notifications
                            return navigator.serviceWorker.register('/service-worker.js')
                                .then(function(registration) {
                                    const subscribeOptions = {
                                    userVisibleOnly: true,
                                    applicationServerKey: urlBase64ToUint8Array(
                                        'BEl62iUYgUivxIkv69yViEuiBIa-Ib9-SkvMeAtA3LFgDzkrxZJjSgSnfckjBJuBkr3qBUYIHBQFLXYp5Nksh8U'
                                    )
                                    };

                                    return registration.pushManager.subscribe(subscribeOptions);
                                })
                                .then(function(pushSubscription) {
                                    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                                    return pushSubscription;
                                });
                        }
                    });
                }
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.register('/service-worker.js').then(function (registration) 
                    {
                        // Registration was successful
                        /*Tell the user that we work offline!*/
                        document.querySelector('main').innerHTML += "<div class='alert alert-warning offline-ready alert-dismissible fade show' role='alert'>النت بيقطع كتير .. بس الموقع ده بيشتغل حتى لو إنت مش فاتح النت! مفيش حاجة هتوقف تجربتك على موقع ثانوية حلوة :)</div>";
                        setTimeout(() => {
                            let el = document.querySelector('.offline-ready');
                            el.parentNode.removeChild(el);
                        }, 5000);

                        //Request notifications
                        /*setTimeout(() => {
                            if (confirm('تقدر تخلي ثانوية حلوة تبعتلك إشعارات (notifications) لموبايلك .. موافق؟')) {
                                askPermission();
                            }
                        }, 10000);*/

                        
                        function updateOnlineStatus() {
                            if (navigator.onLine) {
                                document.body.classList.remove("offline");
                            } else {
                                /*Offline notification*/
                                let offline_box = '<div class="offline-notification">دلوقتي النت مش شغال عندك!<strong><u>يعني إيه؟</u></strong><div class="offline-notification_explanation">الموقع هيفضل شغال عادي ;) في بس شوية الحاجات ممكن متشتغلش غير لما النت يرجع.</div></div>';
                                document.body.innerHTML += offline_box;
                                console.log("test");

                                document.body.classList.add("offline");
                            }
                        }
                        updateOnlineStatus();
                        window.addEventListener('online', updateOnlineStatus);
                        window.addEventListener('offline', updateOnlineStatus);
                    }).catch(function (err) {
                        // registration failed :(
                    });
                }
                //iframe must have title
                setTimeout(() => {
                    if (document.querySelector("iframe[title='']") != null) {
                    document.querySelector("iframe[title='']").title = "Iframe";
                    }
                },5000);
            }

            if (window.addEventListener) {
                window.addEventListener('load',func);
            } else {
                window.attachEvent('onload',func);
            }

        </script>
        @yield('head')
        <link rel="icon" href="{{ Storage::url('assets/images/Logo.ico') }}">
    </head>

    <body>
        @include('partials.splash-screen')
        <header class="sticky-top">
            {{--Navbar --}}
            @if (Str::contains(Route::currentRouteName(),'Tansik'))
                @include('partials.navbar-tansik')
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
    </body>

</html>