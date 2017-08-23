<template>
    <div id="form-payment">
        <h1 class="title is-1">Paiement</h1>
        <form>
            <div class="field">
                <label>
                    <span>Carte de crédit</span>
                    <div id="card-element" class="control"></div>
                </label>
            </div>
            <button class="button is-success is-medium" type="submit" @click.prevent="pay()">Payer</button>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import store from '../store/ReservationStore'

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
            pay() {
                this.stripe.createToken(this.card)
                    .then(res => {
                        return axios({
                            method: 'post',
                            url: '/api/payment',
                            data: res.token.id
                        })
                    }).then(res => {
                        console.log(res)
                    })
            }
        }
    }
</script>

<style lang="sass">
    #form-payment
        width: 600px
        margin: auto

</style>