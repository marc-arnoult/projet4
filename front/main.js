import Vue from 'vue';
import citation from './component/citation-generator.vue';

new Vue({
    el: '#app',
    components: {
        citation
    },
    created() {
        console.log('Vue Enabled')
    }
});