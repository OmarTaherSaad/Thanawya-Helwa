require('./bootstrap');

axios.interceptors.request.use(function (config) {
    //Before request start: show loading
    $("body").addClass("loading");
    return config;
}, function (error) {
    alert("حصل عطل فني، ياريت تحاول في وقت تانية وبلغنا على صفحتنا على الفيسبوك");
    $("body").removeClass("loading");
    return Promise.reject(error);
});
axios.interceptors.response.use(function (response) {
    //After request is done: hide loading
    $("body").removeClass("loading");
    return response;
}, function (error) {
    alert("حصل عطل فني، ياريت تحاول في وقت تانية وبلغنا على صفحتنا على الفيسبوك");
    $("body").removeClass("loading");
    return Promise.reject(error);
});

$(window).bind('load',function() {
		setTimeout(function(){
			$('body').addClass('loaded');
			$('h1').css('color','#222222');
			setTimeout(function(){
				$("#loader-wrapper").remove();
			}, 5000);
		}, 3000);

    });
    
$(document).ready(function () {
    //Thumbnail as a whole link
    $(".thumbnail").click(function () {
        var targetLink = $(this).find(".thumbnail-text")[0].href;
        if (targetLink.indexOf("thanawyahelwa.org") != -1 || targetLink.indexOf("localhost") != -1)
        {
            window.open(targetLink, "_self");
        } else
        {
            window.open(targetLink, "_blank");
        }
    });
    $(".thumbnail-text").click(function (e) {
        e.preventDefault();
    });
});