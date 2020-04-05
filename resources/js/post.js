import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

Vue.component("multiselect", Multiselect);

window.vueApp = new Vue({
    el: "#app",
    data: {
        post_content: "",
        is_draft: 1,
        cowriter: 0,
        state: 0,
        fb_link: "",
        rate: null,
        tags: null,
        tagsOptions: [],
        submitURL: null,
        redirectURL: null,
        alerts: null,
        alertsList: null
    },
    computed: {
        tagsValues() {
            var temp = [];
            if (this.tags != null) {
                this.tags.forEach(v => {
                    temp.push(v.value);
                });
            }
            return temp;
        },
        clean_fb_url() {
            return this.fb_link.slice(
                0,
                this.fb_link.indexOf("?") < 0
                    ? this.fb_link.length
                    : this.fb_link.indexOf("?")
            );
        }
    },
    watch: {
        fb_link() {
            if (this.fb_link != this.clean_fb_url) {
                this.fb_link = this.clean_fb_url;
            }
        }
    },
    methods: {
        savePost() {
            let alerts = "";
            let alertsList = null;
            if (this.post_content.trim().length < 10) {
                alert("Post should be at least 10 characters.");
                return;
            }
            axios
                .post(this.submitURL, {
                    tags: this.tagsValues,
                    content: this.post_content,
                    is_draft: this.is_draft,
                    cowriter: this.cowriter
                })
                .then((response) => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                        this.tags = [];
                        this.post_content = "";
                    }
                })
                .catch((error) => {
                    alertsList = error.errors;
                    alerts = false;
                })
                .finally(function () {
                    window.vueApp.$data.alertsList = alertsList;
                    window.vueApp.$data.alerts = alerts;
                    window.scrollTo(0, 0);
                });
        },
        editPost() {
            let alerts = "";
            let alertsList = null;
            if (this.post_content.trim().length < 10) {
                alert("Post should be at least 10 characters.");
                return;
            }
            axios
                .patch(this.submitURL, {
                    tags: this.tagsValues,
                    content: this.post_content,
                    is_draft: this.is_draft,
                    cowriter: this.cowriter
                })
                .then((response) => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                    }
                })
                .catch((error) => {
                    alertsList = error.errors;
                    alerts = false;
                })
                .finally(function () {
                    window.vueApp.$data.alertsList = alertsList;
                    window.vueApp.$data.alerts = alerts;
                    window.scrollTo(0, 0);
                    if (alerts) {
                        document.body.classList.add("loading");
                        window.location.replace(
                            window.vueApp.$data.redirectURL
                        );
                    }
                });
        },
        approvePost() {
            let alerts = "";
            let alertsList = null;
            axios
                .post(this.submitURL, {
                    tags: this.tagsValues,
                    content: this.post_content,
                    state: this.state,
                    cowriter: this.cowriter,
                    fb_link: this.fb_link,
                    rate: this.rate
                })
                .then(response => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                    }
                })
                .catch(error => {
                    alertsList = error.errors;
                    alerts = false;
                })
                .finally(function() {
                    window.vueApp.$data.alertsList = alertsList;
                    window.vueApp.$data.alerts = alerts;
                    window.scrollTo(0, 0);
                    if (alerts) {
                        document.body.classList.add("loading");
                        window.location.replace(
                            window.vueApp.$data.redirectURL
                        );
                    }
                });
        }
    }
});
