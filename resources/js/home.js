import AOS from "aos";
import "aos/dist/aos.css"; // You can also use <link> for styles

AOS.init({
    duration: 800,
    easing: "slide"
});

(function($) {
    "use strict";

    var fullHeight = function() {
        $(".js-fullheight").css("height", $(window).height());
        $(window).resize(function() {
            $(".js-fullheight").css("height", $(window).height());
        });
    };
    fullHeight();

    var counter = function() {
        $("#eventCounters").waypoint(
            function(direction) {
                if (
                    direction === "down" &&
                    !$(this.element).hasClass("th-animated")
                ) {
                    var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(
                        ","
                    );
                    $(".number").each(function() {
                        var $this = $(this),
                            num = $this.data("number");
                        $this.animateNumber(
                            {
                                number: num,
                                numberStep: comma_separator_number_step
                            },
                            4000
                        );
                    });
                }
            },
            { offset: "95%" }
        );
    };
    counter();

    var contentWayPoint = function() {
        var i = 0;
        $(".th-animate").waypoint(
            function(direction) {
                if (
                    direction === "down" &&
                    !$(this.element).hasClass("th-animated")
                ) {
                    i++;

                    $(this.element).addClass("item-animate");
                    setTimeout(function() {
                        $("body .th-animate.item-animate").each(function(k) {
                            var el = $(this);
                            setTimeout(
                                function() {
                                    var effect = el.data("animate-effect");
                                    if (effect === "fadeIn") {
                                        el.addClass("fadeIn th-animated");
                                    } else if (effect === "fadeInLeft") {
                                        el.addClass("fadeInLeft th-animated");
                                    } else if (effect === "fadeInRight") {
                                        el.addClass(
                                            "fadeInRight th-animated"
                                        );
                                    } else {
                                        el.addClass("fadeInUp th-animated");
                                    }
                                    el.removeClass("item-animate");
                                },
                                k * 50,
                                "easeInOutExpo"
                            );
                        });
                    }, 100);
                }
            },
            { offset: "95%" }
        );
    };
    contentWayPoint();
})(jQuery);
