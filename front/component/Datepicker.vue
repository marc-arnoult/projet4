<template>
    <div class="container" id="datepicker">
        <div class="columns">
            <div class="column has-text-centered">
                <h3 class="title is-5">Date :</h3>
                <input
                        class="input"
                        type="text"
                        :value="date"
                        @blur="setDateEnter('date', $event)"
                        @keyup.enter="setDateEnter('date', $event)"
                >
                <span class="ticket-remaining">Ticket restant : <strong>{{ store.ticketRemaining }}</strong></span>
                <Datepicker
                        :disabled="state.disabled"
                        v-model="state.date"
                        :language="language"
                        :inline="true"
                >
                </Datepicker>
            </div>
            <div class="column">
                <form class="form">
                    <div class="field">
                        <div class="control">
                            <label for=""></label>
                            <input type="text" value="test" class="input">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for=""></label>
                            <input type="number" class="input" v-model="store.numberOfTicket" min="0" :max="store.ticketRemaining">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import moment from 'moment'
    import _ from 'lodash'
    import axios from 'axios'
    import store from '../store/ReservationStore'


    let state = {
        date: new Date(moment()),
        disabled: {
            to: new Date(moment().subtract(1, 'days')),
            days: [2],
            dates: [
                new Date(moment(this.date).format('YYYY'), 4, 1),
                new Date(moment(this.date).format('YYYY'), 10, 1),
                new Date(moment(this.date).format('YYYY'), 11, 25)
            ]
        }
    };

    export default {
        data() {
            return {
                store: store,
                language: 'fr',
                date: '',
                state: state,
                format: 'DD/MM/YYYY'
            }
        },
        components: {
            Datepicker
        },
        mounted() {
            this.date = moment().format('DD/MM/YYYY');
            this.getTickerRemaining(moment().format('YYYY-MM-DD'));
        },
        watch: {
          state: {
              handler(val) {
                 this.date = moment(val.date).format('DD/MM/YYYY');
                 this.getTickerRemaining(val.date);
              },
              deep: true
          }
        },
        methods: {
            setDateEnter(date, event) {
                this.date = event.target.value;
                this.state.date = new Date(moment(event.target.value, 'DD/MM/YYYY'));
            },
            getTickerRemaining(date) {
                let day = moment(date).format('YYYY-MM-DD');
                axios.get('/api/ticket', {
                    params: { day }
                }).then(res => this.store.ticketRemaining = res.data);
            }
        },
    }
</script>

<style lang="sass">
    @import "../../web/assets/css/bulma/sass/utilities/_all"

    #datepicker .input
        width: 290px
        margin-bottom: 20px

    #datepicker .vdp-datepicker__calendar
        margin: auto
        font-size: 1.28rem
        font-family: $family-sans-serif
        width: 520px
        height: 490px
        box-shadow: $box-shadow

    #datepicker .vdp-datepicker__calendar header
        font-weight: 600
        height: 50px
        background-color: $primary
        padding-top: 5px
        color: $primary-invert

    #datepicker .vdp-datepicker__calendar header span:hover
        background-color: $blue-light

    #datepicker .vdp-datepicker__calendar header span
        transition: .3s
        &:hover
            cursor: pointer

    #datepicker .vdp-datepicker__calendar header span.prev::after
        border-right-color: #fff

    #datepicker .vdp-datepicker__calendar header span.next::after
        border-left-color: #fff

    #datepicker .vdp-datepicker__calendar .cell
        border-radius: 65%
        height: 72px
        padding-top: 12px
        transition: .3s

    #datepicker .vdp-datepicker__calendar .cell:hover
        border-color: $primary

    #datepicker .vdp-datepicker__calendar .cell.selected
        background-color: $primary
        color: $primary-invert

    #datepicker .vdp-datepicker__calendar .cell.month
        height: 70px
        padding-top: 12px
    #datepicker .ticket-remaining
        display: block
        margin: 0 auto 16px

    @media screen and (max-width: 550px)
        #datepicker .vdp-datepicker__calendar
            width: 310px
            height: 320px

        #datepicker .vdp-datepicker__calendar .cell
            padding-top: 1px
            height: 44px

</style>