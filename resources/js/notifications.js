import Echo from "laravel-echo";

window.Pusher = require("pusher-js");
window.Echo = new Echo({
    broadcaster: "pusher",
    key: "87b38bfbf726505f518b",
    cluster: "eu",
    forceTLS: true,
    logToConsole: true
});

import iziToast from "izitoast"; // https://github.com/dolce/iziToast
import "izitoast/dist/css/iziToast.min.css";

window.notifApp = new Vue({
    el: "#NotifApp",
    data: {
        notifications: [],
        userId: null,
        markReadURL: null
    },
    computed: {
        oldNotifications() {
            var temp = [];
            if (this.notifications == undefined) return temp;
            this.notifications.forEach(notif => {
                if (notif.read) {
                    temp.push(notif);
                }
            });
            return temp;
        },
        newNotifications() {
            var temp = [];
            if (this.notifications == undefined)
                return temp;
            this.notifications.forEach(notif => {
                if (!notif.read) {
                    temp.push(notif);
                }
            });
            return temp;
        },
        hasUnread() {
            return this.newNotifications.length > 0;
        }
    },
    mounted() {
        //Get Passed values
        this.userId = window.userId;
        this.notifications = window.notifications;
        this.markReadURL = window.markReadURL;
        window.userId = null;
        window.notifications = null;
        window.markReadURL = null;
        //Listen to Broadcasts for New Notifications
        window.Echo.private("App.User." + this.userId).notification(notif => {
            notif.read = false;
            this.notifications.unshift(notif);
            if (this.notifications.length > 10)
            {
                this.notifications.pop();
            }
            this.toast("New Notification!", notif.text, "info");
        });
    },
    methods: {
        markAsRead() {
            axios.post(this.markReadURL).then(res => {
                if (res.data.success != undefined) {
                    //Done
                    window.notifApp.newNotifications.forEach(notif => {
                        notif.read = true;
                    });
                }
            });
        },
        toast(title, message, type, timeout = 5000) {
            iziToast[type]({
                title: title,
                message: message,
                timeout: timeout
            });
            return;
            switch (type) {
                case "info":
                    iziToast.info({
                        title: title,
                        message: message,
                        timeout: timeout
                    });
                    break;
                case "warning":
                    iziToast.warning({
                        title: title,
                        message: message,
                        timeout: timeout
                    });
                    break;
                case "success":
                    console.log("1");

                    iziToast.success({
                        title: title,
                        message: message,
                        timeout: timeout
                    });
                    break;
                case "error":
                    iziToast.error({
                        title: title,
                        message: message,
                        timeout: timeout
                    });
                    break;
            }
        }
    }
});
