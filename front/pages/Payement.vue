<template>
    <div id="form-payment">
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

    export default {
        mounted() {
            this.stripe = Stripe('pk_test_iEZp1ORNhztnwy5qRbdAWTD3');
            this.elements = this.stripe.elements();
            this.card = this.elements.create('card', {
                style: {
                    class: 'input',
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
        data() {
            return {
                stripe: '',
                elements: '',
                card: ''
            }
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
    .StripeElement--focus
        border-color: #1b6d85

    #form-payment
        width: 600px
        margin: auto

</style>