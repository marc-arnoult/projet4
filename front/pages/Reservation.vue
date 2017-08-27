<template>
    <div class="container" id="reservation">
        <ul class="step" id="step">
                <router-link to="/" tag="li" class="step-item" exact>
                    <a>Reservation</a>
                </router-link>
                <router-link to="/command" tag="li" class="step-item" exact>
                    <a>Commande</a>
                </router-link>
                <router-link to="/payment" tag="li" class="step-item" exact>
                    <a>Paiement</a>
                </router-link>
        </ul>
        <transition name="fade">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script>
    import Datepicker from './Datepicker.vue'
    import Command from './Command.vue'
    import Payment from './Payment.vue'
    import VueRouter from 'vue-router'
    import store from '../store/ReservationStore'

    export default {
        props: {
            language: {default: 'fr'}
        },
        router: new VueRouter({
            linkActiveClass: 'is-active',
            routes: [
                {
                    path: '/',
                    name: 'datepicker',
                    component: Datepicker,
                },
                {
                    path: '/command',
                    component: Command,
                },
                {
                    path: '/payment',
                    name: 'payment',
                    component: Payment,
                }
            ]
        }),
    }
</script>

<style lang="sass">
    #reservation
        margin-bottom: 40px

    .fade-enter-active, .fade-leave-active
        transition-property: opacity
        transition-duration: .28s

    .fade-enter-active
        transition-delay: .28s

    .fade-enter, .fade-leave-active
        opacity: 0

</style>