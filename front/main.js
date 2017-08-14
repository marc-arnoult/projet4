
import Vue from 'vue';
import Citation from './component/Citation.vue';
import Reservation from './component/Reservation.vue';
import VueRouter from 'vue-router'
import store from './store/ReservationStore';

Vue.use(VueRouter);
Window.store = store;

new Vue({
    el: '#app',
    components: {
        Citation,
        Reservation
    },
    created() {
        console.log('Vue Enabled')
    }
});