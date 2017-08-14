<template>
    <div class="container" id="reservation">
        <ul class="step" id="step">
            <li class="step-item is-active">
                <a href="#steps"></a>
            </li>
            <li class="step-item">
                <a href="#steps"></a>
            </li>
            <li class="step-item">
                <a href="#steps"></a>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
    import Datepicker from './Datepicker.vue'
    import VueRouter from 'vue-router'
    import store from '../store/ReservationStore'

    export default {
        router: new VueRouter({
            routes: [
                {
                    path: '/',
                    component: Datepicker,
                }
            ]
        })
    }
</script>

<style scoped lang="sass">
    #reservation
        margin-bottom: 40px
</style>