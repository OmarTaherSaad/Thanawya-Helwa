//Vue
import Vue from 'vue';
window.vueApp = new Vue({
    el: '#edgesApp',
    data: {
        toDeleteLink: null
    },
    methods: {
        toDelete(btnClicked) {
            this.toDeleteLink = btnClicked.target.getAttribute('data-link');
        }
    },
});