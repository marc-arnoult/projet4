import Vue from 'vue';
import Citation from './component/Citation.vue';
import Reservation from './component/Reservation.vue';

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