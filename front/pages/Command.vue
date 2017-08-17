<template>
    <div>
        Hello world
        <Ticket v-for="ticket in parseInt(store.numberOfTicket)" :key="ticket.id"></Ticket>
    </div>
</template>

<script>
    import Ticket from '../components/Ticket.vue'
    import store from '../store/ReservationStore'

    export default {
        data() {
            return {
                store
            }
        },
        components: {
            Ticket
        },
    }
</script>