<template>
    <div>
        <Ticket
                v-for="(ticket, index) in parseInt(store.numberOfTicket)"
                :index="index"
                :key="index"
                @setPrice="priceTotal"
        >
        </Ticket>
        <hr>
        <div id="total-price">
            <div>
                Prix total
                <span class="icon tooltip tooltip-bottom" data-tooltip="Ce prix est une estimation">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                </span>
            </div>
            <span>{{ totalPrice }} euros</span>
        </div>
        <div class="has-text-right">
            <button class="button is-success is-medium" :disabled="disabled">Commander</button>
        </div>
    </div>
</template>

<script>
    import Ticket from '../components/Ticket.vue'
    import store from '../store/ReservationStore'

    export default {
        data() {
            return {
                disabled: true,
                totalPrice: 0,
                store,
                tickets: []
            }
        },
        components: {
            Ticket
        },
        methods: {
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