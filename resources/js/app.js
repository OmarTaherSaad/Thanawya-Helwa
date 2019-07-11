require('./bootstrap');

axios.interceptors.request.use(function (config) {
    //Before request start: show loading
    document.body.classList.add('loading');
    return config;
}, function (error) {
    alert("حصل عطل فني، ياريت تحاول في وقت تانية وبلغنا على صفحتنا على الفيسبوك");
    document.body.classList.remove('loading');
    return Promise.reject(error);
});
axios.interceptors.response.use(function (response) {
    //After request is done: hide loading
    document.body.classList.remove('loading');
    return response;
}, function (error) {
    alert("حصل عطل فني، ياريت تحاول في وقت تانية وبلغنا على صفحتنا على الفيسبوك");
    document.body.classList.remove('loading');
    return Promise.reject(error);
});

import 'progressive-image.js/dist/progressive-image.js';
import 'progressive-image.js/dist/progressive-image.css';

let func = function () {
    $("a.progressive").click(function (e) {
        e.preventDefault();
    });
    document.body.classList.add('loaded');
    //Load additional scripts after page loads
    let src = new Array(2);
    src[0] = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
    src.forEach(s => {
        var tag = document.createElement("script");
        tag.src = s;
        document.getElementsByTagName("head")[0].appendChild(tag);
    });
    //Facebook Messenger Plugin
    window.fbAsyncInit = function () {
        FB.init({
            xfbml: true,
            version: 'v3.3'
        });
    };
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/ar_AR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    //PWA Notifications
    /*
    function askPermission() {
        return new Promise(function (resolve, reject) {
                const permissionResult = Notification.requestPermission(function (result) {
                    resolve(result);
                });

                if (permissionResult) {
                    permissionResult.then(resolve, reject);
                }
            })
            .then(function (permissionResult) {
                if (permissionResult == 'granted') {
                    //Subscribe user to notifications
                    return navigator.serviceWorker.register('/service-worker.js')
                        .then(function (registration) {
                            const subscribeOptions = {
                                userVisibleOnly: true,
                                applicationServerKey: urlBase64ToUint8Array(
                                    'BEl62iUYgUivxIkv69yViEuiBIa-Ib9-SkvMeAtA3LFgDzkrxZJjSgSnfckjBJuBkr3qBUYIHBQFLXYp5Nksh8U'
                                )
                            };

                            return registration.pushManager.subscribe(subscribeOptions);
                        })
                        .then(function (pushSubscription) {
                            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                            return pushSubscription;
                        });
                }
            });
    }
    */
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js').then(function (registration) {
            // Registration was successful
            /*Tell the user that we work offline! (First time only)*/
            if (navigator.serviceWorker.controller == null) {
                document.querySelector('main').innerHTML += "<div class='alert alert-warning offline-ready alert-dismissible fade show' role='alert'>النت بيقطع كتير .. بس الموقع ده بيشتغل حتى لو إنت مش فاتح النت! مفيش حاجة هتوقف تجربتك على موقع ثانوية حلوة :)</div>";
                setTimeout(() => {
                    let el = document.querySelector('.offline-ready');
                    el.parentNode.removeChild(el);
                }, 5000);
            }

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
        });
    }
    //iframe must have title
    setTimeout(() => {
        if (document.querySelector("iframe[title='']") != null) {
            document.querySelector("iframe[title='']").title = "Iframe";
        }
    }, 5000);
}

if (window.addEventListener) {
    window.addEventListener('load', func);
} else {
    window.attachEvent('onload', func);
}
