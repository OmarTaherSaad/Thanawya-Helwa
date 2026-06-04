require("./bootstrap");
import "lazysizes";

/**
 * Ensure navbar dropdowns work: Bootstrap delegates clicks on document, but Vue
 * re-renders (e.g. notifications bell) and stacking contexts can require instances.
 */
function initNavbarDropdowns() {
    if (!window.bootstrap || !window.bootstrap.Dropdown) {
        return;
    }
    document.querySelectorAll('.navbar [data-bs-toggle="dropdown"]').forEach((el) => {
        try {
            window.bootstrap.Dropdown.getOrCreateInstance(el);
        } catch (_) {
            /* ignore */
        }
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initNavbarDropdowns);
} else {
    initNavbarDropdowns();
}
window.addEventListener("load", initNavbarDropdowns);

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
