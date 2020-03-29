require("./bootstrap");

axios.interceptors.request.use(
    function(config) {
        //Before request start: show loading
        document.body.classList.add("loading");
        return config;
    },
    function(error) {
        alert(
            "حصل عطل فني، ياريت تحاول في وقت تاني وبلغنا على صفحتنا على الفيسبوك"
        );
        document.body.classList.remove("loading");
        return Promise.reject(error);
    }
);
axios.interceptors.response.use(
    function(response) {
        //After request is done: hide loading
        document.body.classList.remove("loading");
        return response;
    },
    function(error) {
        alert(
            "حصل عطل فني، ياريت تحاول في وقت تاني وبلغنا على صفحتنا على الفيسبوك"
        );
        document.body.classList.remove("loading");
        return Promise.reject(error);
    }
);

let func = function() {
    document.body.classList.add("loaded");
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
    //Register Service Worker
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker
            .register("/service-worker.js")
            .then(function(registration) {
                // Registration was successful
                /*Tell the user that we work offline! (First time only)*/
                if (navigator.serviceWorker.controller == null) {
                    let el = document.createElement("div");
                    el.classList.add(
                        "alert",
                        "alert-info",
                        "offline-ready",
                        "alert-dismissible",
                        "fade",
                        "show"
                    );
                    el.setAttribute("role", "alert");
                    el.innerHTML =
                        "الموقع ده معظم صفحاته بتشتغل حتى لو بدون انترنت .. تجربتك معانا مختلفة!";
                    document.querySelector("main").append(el);
                    setTimeout(function() {
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
                        let offline_box =
                            '<div class="offline-notification">دلوقتي النت مش شغال عندك!<strong><u>يعني إيه؟</u></strong><div class="offline-notification_explanation">الموقع هيفضل شغال عادي ;) في بس شوية الحاجات ممكن متشتغلش غير لما النت يرجع.</div></div>';
                        document.body.innerHTML += offline_box;

                        document.body.classList.add("offline");
                    }
                }
                updateOnlineStatus();
                window.addEventListener("online", updateOnlineStatus);
                window.addEventListener("offline", updateOnlineStatus);
            });
    }
    //iframe must have title
    if (document.querySelector("iframe[title='']") != null) {
        document.querySelector("iframe[title='']").title = "Iframe";
    }
};

if (window.addEventListener) {
    window.addEventListener("load", func);
} else {
    window.attachEvent("onload", func);
}
