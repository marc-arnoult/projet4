<template>
    <form class="container contact" id="#contact">
        <h4 class="title is-3 has-text-centered">Contact</h4>
        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    <div class="control is-expanded">
                        <label for="">Sujet :</label>
                        <input v-model="subject" type="text" class="input is-medium">
                    </div>
                </div>
                <div class="field">
                    <div class="control is-expanded">
                        <label for="">Email :</label>
                        <input v-model="email" type="email" class="input is-medium">
                    </div>
                </div>
            </div>
        </div>
        <div class="field">
            <label>Message :</label>
            <div class="control">
                <textarea v-model="message" class="textarea" placeholder="Textarea"></textarea>
            </div>
        </div>
        <button type="submit" class="button is-success is-medium" @click.prevent="sendMsg">Envoyer</button>
    </form>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                email: '',
                subject: '',
                message: ''
            }
        },
        methods: {
            sendMsg() {
                axios({
                    method: 'post',
                    url: '/api/contact',
                    data: {
                        from: this.email,
                        subject: this.subject,
                        message: this.message
                    }
                }).then(res => {
                    if (res.status === 201) {
                        console.log('ok')
                    }
                }).catch(err => {
                    console.log('Erreur')
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    .contact
        margin-top: 130px
</style>