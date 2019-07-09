require('./bootstrap');

import 'progressive-image.js/dist/progressive-image.js';
import 'progressive-image.js/dist/progressive-image.css';

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
        document.body.classList.add('loaded');
        //Footer to bottom
        //viewport height
        var viewPortHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
        if (document.body.getBoundingClientRect().height < viewPortHeight)
        {
            //Needs to be adjusted
            let positionTop = viewPortHeight - document.querySelector('footer').getBoundingClientRect().height;
            document.querySelector('footer').style.top = positionTop + 'px';
        }
        //document.querySelector('footer').style.marginTop = document.querySelector('footer').clientHeight + 'px';
    }

    if (window.addEventListener) {
        window.addEventListener('load', func);
    } else {
        window.attachEvent('onload', func);
    }