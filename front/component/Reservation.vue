<template>
    <div class="container">
        <ul class="step" id="step">
            <li class="step-item is-active">
                <a href="#steps"></a>
            </li>
            <li class="step-item">
                <a href="#steps"></a>
            </li>
            <li class="step-item">
                <a href="#steps"></a>
            </li>
        </ul>
        <Datepicker :language="language"></Datepicker>
    </div>
</template>

<script>
    import Datepicker from './Datepicker.vue'

    export default {
        props: {
            language: {default: 'fr'}
        },
        components: {
            Datepicker
        }
    }
</script>