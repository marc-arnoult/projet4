<template>
    <div>
        Hello world
        <Ticket v-for="ticket in parseInt(store.numberOfTicket)"></Ticket>
    </div>
</template>

<script>
    import Ticket from './Ticket.vue'
    import store from '../store/ReservationStore'

    export default {
        data() {
            return {
                store
            }
        },
        components: {
            Ticket
        }
    }
</script>