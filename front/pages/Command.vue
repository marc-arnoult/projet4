<template>
    <div>
        <Ticket v-for="(ticket, index) in parseInt(store.numberOfTicket)" :index="index" :key="index"></Ticket>
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