import AOS from "aos";
import "aos/dist/aos.css"; // You can also use <link> for styles
import "waypoints/lib/jquery.waypoints";
import 'jquery.animate-number';
import 'jquery.easing';

AOS.init({
    duration: 800,
    easing: "slide"
});

(function($) {
    "use strict";

    var fullHeight = function() {
        // Fill viewport from the hero’s top edge (navbar + optional flash row), not from window top only.
        var apply = function() {
            var $hero = $(".js-fullheight").first();
            if (!$hero.length) {
                return;
            }
            var top = $hero[0].getBoundingClientRect().top;
            var h = Math.max(280, $(window).height() - top);
            $(".js-fullheight").css({ height: h, minHeight: h });
        };
        apply();
        $(window).on("resize", apply);
    };
    fullHeight();

    var waypointCounter = new Waypoint({
        element: document.getElementById("eventCounters"),
        handler: function(direction) {
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
                        $this.data("speed") || 4000
                    );
                });
            }
        },
        offset: "95%"
    });
})(jQuery);
