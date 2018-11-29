/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

require('./helpers/messagePopUp');

require('./helpers/menuPopUp');

require('./helpers/opretNySupervisorPopUp');

require('./helpers/comments');

import router from './routes';

Vue.component('sidebar', require('./components/sidebar.vue'));
Vue.component('sidebarformanagers', require('./components/SidebarForManagers.vue'));

new Vue({
    el: '#app',
    data: function () {
        return {
            counterMain: 1
        }
    },
    router,
    methods: {
        incrementTotal: function () {
        this.counterMain +=1;
        }
    }
});
