import Vue from 'vue';
import router from './router';
import App from './App.vue';
import store from './store/store';

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
    store
});
