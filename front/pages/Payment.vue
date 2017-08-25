<template>
    <div id="form-payment">
        <div class="columns">
            <div class="column is-two-thirds">
                <h1 class="title is-3 has-text-centered">Paiement</h1>
                <form>
                    <div class="field">
                        <label>
                            <span>Carte de crédit</span>
                            <hr>
                            <div id="card-element" class="control"></div>
                        </label>
                    </div>
                    <div class="has-text-right">
                        <button class="button is-medium">Annuler</button>
                        <button class="button is-success is-medium" type="submit" @click.prevent="pay($event)">Valider ma commande</button>
                    </div>
                </form>
            </div>
            <div class="column">
                <h2 class="title is-3 has-text-centered">Résumé de la commande</h2>
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">Nombre d'article : {{ store.nbTickets }}</p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div v-for="(ticket, index) in store.tickets">
                                <div class="ticket-resume">
                                    <span>Ticket n°{{ index + 1 }}</span>
                                    <span>{{ ticket.price }} euros</span>
                                </div>
                            </div>
                            <hr>
                            <div class="ticket-resume">
                                <span class="bold">Total :</span>
                                <span class="bold">{{ store.priceCommand }} euros</span>
                            </div>
                            <div class="ticket-resume">
                                <span class="bold">Email :</span>
                                <span class="bold">{{ store.email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import store from '../store/ReservationStore'
    import CxltToastr from 'cxlt-vue2-toastr'
    import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'
    import Vue from 'vue'

    const toastrConfigs = {
        position: 'top full width',
        successColor: '#70C25A',
        showMethod: 'bounceInDown',
    };

    Vue.use(CxltToastr, toastrConfigs);

    export default {
        data() {
            return {
                store,
                stripe: '',
                elements: '',
                card: ''
            }
        },
        mounted() {
            this.stripe = Stripe('pk_test_iEZp1ORNhztnwy5qRbdAWTD3');
            this.elements = this.stripe.elements();
            this.card = this.elements.create('card', {
                style: {
                    base: {
                        iconColor: '#666EE8',
                        color: '#777',
                        lineHeight: '50px',
                        fontWeight: 300,
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSize: '18px',

                        '::placeholder': {
                            color: '#666',
                        },
                    },
                }
            });

            this.card.mount('#card-element');
        },
        methods: {
            pay(event) {
                event.target.classList.add('is-loading');

                this.stripe.createToken(this.card)
                    .then(res => {
                        return axios({
                            method: 'post',
                            url: '/api/payment',
                            data: res.token.id
                        })
                    }).then(res => {
                        event.target.classList.remove('is-loading');

                        if (res.status === 201) {
                            this.$toast.success({
                                message: res.data,
                                timeOut: 6000
                            });
                            setTimeout(() => {
                               window.location = '/'
                            }, 7000)
                        }
                    }).catch(err => {
                        event.target.classList.remove('is-loading');

                        this.$toast.error({
                            message: err.response.data,
                            timeOut: 6000
                        })
                    })
            }
        }
    }
</script>

<style lang="sass">
    #form-payment form > .field
        box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1)
        padding: 30px
    .ticket-resume
        display: flex
        justify-content: space-between
    .bold
        font-weight: bold
</style>