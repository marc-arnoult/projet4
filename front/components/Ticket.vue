<template>
    <div>
        <div class="field">
            <div class="control">
                <input type="text" class="input">
                <input type="text" class="input">
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