import Vue from 'vue';

window.vueApp = new Vue({
    el: "#app",
    data: {
        submitURL: null,
        alerts: null,
        alertsList: null,
        emails: "",
        mail_body: "",
        mail_subject: ""
    },
    methods: {
        sendMails() {
            let alerts = "";
            let alertsList = null;
            this.mail_body = $("#textEditor").summernote("code");
            if (this.mail_body.trim().length < 10) {
                alert("Mail should be at least 10 characters.");
                return;
            }
            axios
                .post(this.submitURL, {
                    mail: this.mail_body,
                    subject: this.mail_subject,
                    emails: this.emails
                })
                .then(response => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                        this.mail_body = "";
                        $("#textEditor").summernote("code", "");
                        this.mail_subject = "";
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
                });
        }
    }
});
