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

let func = function () {
    setTimeout(function () {
        document.body.classList.add('loaded');
        setTimeout(function () {
            let el = document.getElementById('loader-wrapper');
            el.parentNode.removeChild(el);
        }, 5000);
    }, 3000);

    //Thumbnail as a whole link
    $(".thumbnail").click(function () {
        var targetLink = $(this).find(".thumbnail-text")[0].href;
        if (targetLink.indexOf("thanawyahelwa.org") != -1 || targetLink.indexOf("localhost") != -1) {
            window.open(targetLink, "_self");
        } else {
            window.open(targetLink, "_blank");
        }
    });
    $(".thumbnail-text").click(function (e) {
        e.preventDefault();
    });
}

if (window.addEventListener) {
    window.addEventListener('load', func);
} else {
    window.attachEvent('onload', func);
}