<template>
    <div class="ticket">
        <div class="ticket-title">
            <span>Ticket {{ index }}</span>
            <span>Prix</span>
        </div>
        <hr>
        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    <label for="nom" class="label has-text-left">Nom</label>
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Name" name="nom">
                        <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label for="prenom" class="label has-text-left">Prenom</label>
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Prenom">
                        <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    <label for="" class="label has-text-left">Label</label>
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Name">
                        <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label for="" class="label has-text-left">Label</label>
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Name">
                        <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            index: {
                type: Number,
                required: false
            }
        }
    }
</script>

<style scoped lang="sass">
    .ticket
        margin-bottom: 80px

    .ticket-title
        display: flex
        justify-content: space-between
</style>