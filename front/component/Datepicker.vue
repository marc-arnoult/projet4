<template>
    <div class="container" id="datepicker">
        <div class="columns is-centered">
            <div class="column">
                <h3 class="title is-5">Date :</h3>
                <div class="control">
                    <input
                            class="input"
                            type="text"
                            :value="date"
                            @blur="setDateEnter($event)"
                            @keyup.enter="setDateEnter($event)"
                    >
                    <span class="ticket-remaining">Ticket restant : <strong>{{ store.ticketRemaining }}</strong></span>
                </div>
                <Datepicker
                        :disabled="state.disabled"
                        v-model="state.date"
                        :inline="true"
                        :language="this.language"
                >
                </Datepicker>
            </div>
            <div class="column">
                <form class="form">
                    <div class="field">
                        <label for="">Email</label>
                        <span class="icon tooltip tooltip-right is-hidden-mobile" data-tooltip="email d'envoi des billets">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                        <div class="control has-icons-left has-icons-right">
                            <input
                                    type="email"
                                    class="input"
                                    v-model="store.email"
                                    @blur="isValidMail($event)"
                            >
                            <span class="icon is-small is-left">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right" v-if="!testEmail(store.email)">
                                <i class="fa fa-warning"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label>Nombre de tickets</label>
                        <div class="control">
                            <input
                                    type="number"
                                    class="input"
                                    @blur="isValidNumber($event)"
                                    v-model="store.numberOfTicket"
                                    min="0"
                                    :max="store.ticketRemaining"
                            >
                        </div>
                    </div>
                    <div class="field">
                        <label>Type</label>
                        <span class="icon tooltip tooltip-right is-hidden-mobile" data-tooltip="billet demi-journée valable à partir de 14h">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                        <div class="control">
                            <div class="select">
                                <select v-model="store.type">
                                    <option value="Journée">Journées</option>
                                    <option value="Demi-journée">Demi-journées</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <router-link to="/bar" class="button is-blue is-medium">Reservation</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import moment from 'moment'
    import holiday from 'moment-ferie-fr'
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

    let lists = moment().getFerieList();

    lists.forEach(list => {
        state.disabled.dates.push(new Date(list.date))
    });

    export default {
        data() {
            return {
                language: this.$parent.language,
                store: store,
                date: '',
                state: state,
                format: 'DD/MM/YYYY'
            }
        },
        components: {
            Datepicker
        },
        mounted() {
            if (moment().format('d') == 2) {
                this.date = "Vous ne pouvez pas reserver pour aujourd'hui"
            } else {
                this.date = moment().format('DD/MM/YYYY')
            }
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
            setDateEnter(event) {
                this.date = event.target.value;
                this.state.date = new Date(moment(event.target.value, 'DD/MM/YYYY'));
            },
            getTickerRemaining(date) {
                let day = moment(date).format('YYYY-MM-DD');

                axios.get('/api/ticket', {
                    params: { day }
                }).then(res => this.store.ticketRemaining = res.data);
            },
            testEmail(value) {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
                    return true;
                } else {
                    return false
                }
            },
            isValidMail(event) {
                let email = event.target.value;

                if (this.testEmail(email)) {
                    event.target.classList.remove('is-danger');
                    event.target.classList.add('is-success');

                    this.store.email = email;
                } else {
                    event.target.classList.remove('is-success');
                    event.target.classList.add('is-danger');
                }
            },
            isValidNumber(event) {
                let number = event.target.value;

                if (number > store.ticketRemaining) {
                    event.target.classList.remove('is-success');
                    event.target.classList.add('is-danger');
                } else {
                    event.target.classList.remove('is-danger');
                    event.target.classList.add('is-success');
                }
            }
        },
    }
</script>

<style lang="sass">
    @import "../../web/assets/css/bulma/sass/utilities/_all"
    #datepicker
        .column:nth-child(2) > form > div:nth-child(1)
            margin-top: 23px

        .column:nth-child(2) > form > div:nth-child(n+2)
            margin-top: 60px

        .control
            width: 370px
            margin-bottom: 20px

        .vdp-datepicker__calendar
            font-size: 1.28rem
            font-family: $family-sans-serif
            width: 520px
            height: 490px
            box-shadow: $box-shadow

        .vdp-datepicker__calendar header
            font-weight: 600
            height: 50px
            background-color: $primary
            padding-top: 5px
            color: $primary-invert

        .vdp-datepicker__calendar header span:hover
            background-color: $blue-light

        .vdp-datepicker__calendar header span
            transition: .3s
            &:hover
                cursor: pointer

        .vdp-datepicker__calendar header span.prev::after
            border-right-color: #fff

        .vdp-datepicker__calendar header span.next::after
            border-left-color: #fff

        .vdp-datepicker__calendar .cell
            border-radius: 65%
            height: 72px
            padding-top: 13px
            transition: .3s

        .vdp-datepicker__calendar .cell:hover
            border-color: $primary

        .vdp-datepicker__calendar .cell.selected
            background-color: $primary
            color: $primary-invert

        .vdp-datepicker__calendar .cell.month
            height: 70px
            padding-top: 12px
        .ticket-remaining
            display: block
            margin: 0 auto 16px

    @media screen and (max-width: 550px)
        #datepicker
            .input
                width: 100%

            .vdp-datepicker__calendar
                width: 100%
                height: 300px

            .vdp-datepicker__calendar .cell
                padding: 0
                border-radius: 2%
                height: 38px

            .input
                width: 100%

</style>