//Vue
import Vue from 'vue';

import { QrcodeStream } from 'vue-qrcode-reader';
import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);
window.vueApp = new Vue({
    el: '#edgesApp',
    components: {
        'qrcode-stream': QrcodeStream,
    },
    data: {
        ticket_owner: null,
        ticket: null,
        ticket_serial: null,
        paymentMethod: "offline-Ebda3",
        offlineTicketSerial: '',
        onlinePayment: {
            sameMobile: true,
            mobile: '',
            studentsCount: 1,
            parentsCount: 0,
            hasPayment: null,
            ticket_url: null,
        },
        register: {
            success: 'alert alert-danger',
            message: null
        }
    },
    computed: {
        paymentIsOnline() {
            return this.paymentMethod.includes('online');
        }
    },
    methods: {
        ValidateQR(value) {
<<<<<<< Updated upstream
            axios.post('/TAS/tickets/verify', {
=======
            this.camera = 'off';
            axios.post('/tas/tickets/verify', {
>>>>>>> Stashed changes
                ticket_token: value
            })
            .then(function (response) {
                if (response.data.success)
                {
                    //Succeed
                    window.vueApp.ticket = JSON.parse(response.data.ticket);
                    window.vueApp.ticket_owner = JSON.parse(response.data.ticket_owner);
                    window.vueApp.ticket_serial = response.data.ticket_serial;
                } else
                {
                    //Failed
                    alert("حصل عطل من عندنا، ياريت تحاول في وقت تاني.");
                }
            })
            .catch(function (error) {
                // handle error
            });
        },
        registerTicketFromQR(value) {
            axios.post('/tas/tickets/register', {
                ticket_token: value,
                paymentMethod: window.vueApp.paymentMethod
            })
            .then(function (response) {
                window.vueApp.register.success = response.data.success ? 'alert alert-success' : 'alert alert-danger';
                if (response.data.success)
                {
                    //Succeed
                    window.vueApp.ticket = JSON.parse(response.data.ticket);
                    window.vueApp.ticket_serial = response.data.ticket_serial;
                    window.vueApp.register.message = 'تم تسجيل التذكرة بنجاح!';
                } else
                {
                    //Failed
                    window.vueApp.register.message = response.data.message;
                }
            })
            .catch(function (error) {
                // handle error
            });
        },
        registerTicketFromSerial() {
            var serial = window.vueApp.offlineTicketSerial.replace(/-/g, '');
            if (serial.length != 16)
            {
                alert('برجاء إدخال السيريال كاملًا (16 حرف/رقم)');
                return;
            }
            axios.post('/tas/tickets/register', {
                ticket_serial: serial,
                paymentMethod: window.vueApp.paymentMethod
            })
            .then(function (response) {
                window.vueApp.register.success = response.data.success ? 'alert alert-success' : 'alert alert-danger';
                if (response.data.success)
                {
                    //Succeed
                    window.vueApp.ticket = JSON.parse(response.data.ticket);
                    window.vueApp.ticket_serial = response.data.ticket_serial;
                    window.vueApp.register.message = 'تم تسجيل التذكرة بنجاح!';
                } else
                {
                    //Failed
                    window.vueApp.register.message = response.data.message;
                }
            })
            .catch(function (error) {
                // handle error
            });
        },
        registerTicketFromMobile() {
            var mobile;
            var data = {
                paymentMethod: window.vueApp.paymentMethod,
                studentsCount: window.vueApp.onlinePayment.studentsCount,
                parentsCount: window.vueApp.onlinePayment.parentsCount
            };
            if (!this.onlinePayment.sameMobile)
            {
                mobile = this.onlinePayment.mobile.replace(/\s/g, '');
                if (mobile.length != 11) {
                    alert('برجاء إدخال الرقم كاملًا (11 رقم)');
                    return;
                }
                data.paymentMobile = this.onlinePayment.mobile;
            }
            axios.post('/tas/tickets/register-to-mobile', data)
            .then(function (response) {
                window.vueApp.register.success = 'alert alert-';
                window.vueApp.register.success += response.data.alertClass;
                window.vueApp.register.message = response.data.message;
                window.vueApp.onlinePayment.hasPayment = response.data.hasPayment;
            })
            .catch(function (error) {
                // handle error
            });
<<<<<<< Updated upstream
=======
        },
        Entered() {
            axios.post('/tas/tickets/enter', {
                    ticket_token: this.ticket.secret_token,
                })
                .then(function (response) {
                    window.vueApp.register.success = 'alert alert-';
                    window.vueApp.register.success += response.data.alertClass;
                    window.vueApp.register.message = response.data.message;
                })
                .catch(function (error) {
                    // handle error
                });
            this.camera = 'auto';
        },
        Cancelled() {
            this.ticket = null;
            this.camera = 'auto';
>>>>>>> Stashed changes
        }
    },
});