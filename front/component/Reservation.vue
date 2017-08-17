<template>
    <div class="container" id="reservation">
        <ul class="step" id="step">
                <router-link to="/" tag="li" class="step-item">
                    <a>/foo</a>
                </router-link>
                <router-link to="/aaa" tag="li" class="step-item">
                    <a>/foo</a>
                </router-link>
                <router-link to="/aaaaa" tag="li" class="step-item">
                    <a>/foo</a>
                </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
    import Datepicker from './Datepicker.vue'
    import Command from './Command.vue'
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
                    component: Datepicker,
                },
                {
                    path: '/command',
                    component: Command,
                    beforeEnter: (to, from, next) => {
                        if (store.email !== '' && store.numberOfTicket !== 0 && store.type !== '') {
                            next()
                        } else {
                            alert('Merci de remplir tout les champs')
                        }
                    }
                }
            ]
        }),
    }
</script>

<style scoped lang="sass">
    #reservation
        margin-bottom: 40px
</style>