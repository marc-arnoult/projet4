
import Vue from 'vue';
import Citation from './components/Citation.vue';
import Reservation from './pages/Reservation.vue';
import VueRouter from 'vue-router';
import Contact from './components/Contact.vue';
import store from './store/ReservationStore';
import * as VueGoogleMaps from 'vue2-google-maps';

Vue.use(VueRouter);
Vue.use(VueGoogleMaps, {
    load: {key: 'AIzaSyAUSnEiemV5tXF7Zz7ZgNYuPnIOKOe547c'}
});

Window.store = store;

new Vue({
    data() {
        return {
            center: {lat:48.860294, lng:2.338629},
            markers: [{
                position: {lat:48.860294, lng:2.338629}
            }]
        }
    },
    el: '#app',
    components: {
        Citation,
        Reservation,
        Contact
    },
    created() {
        console.log('Vue Enabled')
    }
});