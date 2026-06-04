/**
 * edges.js is a separate Mix entry from app.js, so it gets its own axios module instance.
 * Vuetable posts to Laravel web routes; align defaults with resources/js/bootstrap.js
 * so CSRF and X-Requested-With are sent on every request from this bundle.
 */
import axios from "axios";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common.Accept = "application/json";

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token && token.getAttribute("content")) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute(
        "content"
    );
} else {
    console.error(
        "CSRF token meta missing; coordination POST requests may fail with 419."
    );
}
