<template>
    <div class="container" id="datepicker">
        <div class="columns is-centered">
            <div class="column">
                <h3 class="title is-5">Date* :</h3>
                <div class="control">
                    <input
                            class="input is-medium"
                            type="text"
                            :value="store.entry_at"
                            @blur="setDateEnter($event)"
                            @keyup.enter="setDateEnter($event)"
                    >
                    <span class="ticket-remaining">{{ t('Ticket restant') }} : <strong>{{ store.ticketRemaining }}</strong></span>
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
                        <label for="">Email*</label>
                        <span class="icon tooltip tooltip-right is-hidden-mobile" data-tooltip="email d'envoi des billets">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                        <div class="control">
                            <input
                                    type="email"
                                    class="input is-medium"
                                    v-model="store.email"
                                    @blur="isValidMail($event)"
                                    required
                            >
                        </div>
                    </div>
                    <div class="field">
                        <label>{{ t('Nombre de tickets*') }}</label>
                        <div class="control">
                            <input
                                    type="number"
                                    class="input is-medium"
                                    @blur="isValidNumber($event)"
                                    v-model="store.numberOfTicket"
                                    min="0"
                                    :max="store.ticketRemaining"
                                    required
                            >
                        </div>
                    </div>
                    <div class="field">
                        <label>Type*</label>
                        <span class="icon tooltip tooltip-right is-hidden-mobile" data-tooltip="billet demi-journée valable à partir de 14h">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </span>
                        <div class="control">
                            <div class="select is-medium">
                                <select v-model="store.type" required @blur="isValidType($event)">
                                    <option value="Journée">Journées</option>
                                    <option value="Demi-journée">Demi-journées</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <router-link tag="button" to="/command" class="button is-success is-medium" :disabled="disabled">Reservation</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueTranslate from 'vue-translate-plugin';
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';
    import holiday from 'moment-ferie-fr';
    import _ from 'lodash';
    import axios from 'axios';
    import store from '../store/ReservationStore';
    import CxltToastr from 'cxlt-vue2-toastr';
    import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';

    const toastrConfigs = {
        position: 'top full width',
        successColor: '#70C25A',
        showMethod: 'bounceInDown',
    };

    Vue.use(CxltToastr, toastrConfigs);
    Vue.use(VueTranslate);

    let state = {
        date: new Date(moment()),
        disabled: {
            to: new Date(moment().subtract(1, 'days')),
            days: [0, 2],
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
                disabled: true,
                language: this.$parent.language,
                store: store,
                state: state,
                format: 'DD/MM/YYYY'
            }
        },
        locales: {
            en: {
                'Ticket restant': 'Remaining ticket',
                'Nombre de tickets*': 'Number of tickets*',
            }
        },
        components: {
            Datepicker
        },
        methods: {
            setDateEnter(event) {
                this.store.entry_at = new Date(moment(event.target.value, 'YYYY-MM-DD'));
                this.state.date = new Date(moment(event.target.value, 'YYYY-MM-DD'));
            },
            getTickerRemaining(date) {
                let day = moment(date).format('YYYY-MM-DD');

                axios.get('/api/ticket', {
                    params: { day }
                }).then(res => this.store.ticketRemaining = res.data);
            },
            testEmail(value) {
                return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
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
                let number = parseInt(event.target.value);

                if (number > store.ticketRemaining || number === 0) {
                    event.target.classList.remove('is-success');
                    event.target.classList.add('is-danger');
                } else {
                    event.target.classList.remove('is-danger');
                    event.target.classList.add('is-success');
                }
            },
            isValidType(event) {
                let type = event.target.value;
                if (type) {
                    event.target.parentNode.classList.remove('is-danger');
                    event.target.parentNode.classList.add('is-success');
                }
            }
        },
        mounted() {
            this.$translate.setLang(store.language);

            if (moment().format('d') === 2) {
                this.store.entry_at = "Vous ne pouvez pas reserver pour aujourd'hui"
            } else {
                this.store.entry_at = moment().format('DD/MM/YYYY')
            }
            this.getTickerRemaining(moment().format('YYYY-MM-DD'));
        },
        watch: {
            state: {
                handler(val) {
                    this.store.entry_at = moment(val.date).format('DD/MM/YYYY');
                    this.getTickerRemaining(val.date);
                },
                deep: true
            }
        },
        updated: _.debounce(function () {
            for (let key in this.store) {
                if (this.store[key] === '') {
                    this.disabled = true;
                    return;
                }
                this.disabled = false;
            }
        }, 500),
        beforeRouteLeave: function (from, to, next) {
            let actualHour = moment().format('H');
            let disabledDate = this._data.state.disabled;
            let isValid = true;

            for (let key in disabledDate) {
                _.forEach(disabledDate[key], (val) => {
                    if (moment(val).format('dmY') === moment(store.entry_at).format('dmY')) {
                        this.$toast.error({
                            message: 'Vous ne pouvez reserver pour ce jour.',
                            timeOut: 6000
                        });
                        return isValid = false;
                    }
                });
            }
            if (store.type === "Journée" && actualHour >= 14 && moment(this.state.date).format('dmY') === moment().format('dmY')) {
                this.$toast.error({
                    message: 'Ticket journée indisponible après 14h.',
                    timeOut: 6000
                });
                return;
            }

            if (
                store.email !== '' &&
                store.numberOfTicket !== 0 &&
                store.type !== '' &&
                isValid === true
            ) {
                next()
            } else {
                this.$toast.error({
                    message: 'Veuillez remplir les champs correctement.',
                    timeOut: 6000
                });
            }
        }
    }
</script>

<style lang="sass">
    @import "../../web/assets/css/bulma/sass/utilities/all"

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