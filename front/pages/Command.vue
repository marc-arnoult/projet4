<template>
    <div>
        <Ticket
                v-for="(ticket, index) in parseInt(store.numberOfTicket)"
                :index="index"
                :key="index"
                @setPrice="priceTotal()"
        >
        </Ticket>
        <hr>
        <div id="total-price">
            <div>
                {{ t('Prix total') }}
                <span class="icon tooltip tooltip-bottom" data-tooltip="Ce prix est une estimation">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                </span>
            </div>
            <span>{{ totalPrice }} euros</span>
        </div>
        <div class="has-text-right">
            <button class="button is-success is-medium" :disabled="disabled" @click="payment()">
                {{ t('Commander') }}
            </button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueTranslate from 'vue-translate-plugin';
    import Ticket from '../components/Ticket.vue'
    import store from '../store/ReservationStore'
    import axios from 'axios'
    import moment from 'moment'
    import CxltToastr from 'cxlt-vue2-toastr'
    import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'

    const toastrConfigs = {
        position: 'top full width',
        successColor: '#70C25A',
        showMethod: 'bounceInDown',
    };

    Vue.use(CxltToastr, toastrConfigs);

    export default {
        data() {
            return {
                disabled: true,
                totalPrice: 0,
                store,
                command: {}
            }
        },
        locales: {
            en: {
                'Prix total': 'Total price',
                'Commander': 'Order',
            }
        },
        components: {
            Ticket
        },
        methods: {
            payment() {
                this.store.tickets = [];
                this.$children.forEach(child => {
                    this.store.tickets.push(child._data.ticket)
                });

                this.command.type = this.store.type;
                this.command.email = this.store.email;
                this.command.entryAt = this.store.entry_at;
                this.command.tickets = this.store.tickets;

                axios({
                    method: 'post',
                    url: '/api/command',
                    data: this.command
                }).then(res => {
                    this.store.priceCommand = res.data.price;
                    this.store.nbTickets = res.data.nbTickets;
                    this.store.started = res.data.started;
                    this.$parent._router.push('/payment')
                }).catch(err => {
                    console.log(err.response);
                    this.$toast.error({
                        message: err.response.data,
                        timeOut: 6000
                    })
                });
            },
            priceTotal() {
                let total = 0;

                this.$children.forEach(child => {
                    total += parseInt(child._data.ticket.price);
                });

                this.totalPrice = total;
            },
            isCompleted() {
                this.$children.forEach(child => {
                    let ticket = child._data.ticket;

                    for (let key in ticket) {
                        if (ticket[key] === '') {
                            this.disabled = true;
                            return;
                        }
                        this.disabled = false;
                    }
                });
            }
        },
        mounted() {
            this.priceTotal()
        },
        updated() {
            this.priceTotal();
        }
    }
</script>

<style scoped lang="sass">
        #total-price
            font-size: 1.6rem
            display: flex
            justify-content: space-between
            margin-bottom: 30px
</style>