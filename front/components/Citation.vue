<template>
    <div id="citation-generator">
        <div class="hero-body">
            <div class="container has-text-centered hero">
                <blockquote>"{{ citation.quote }}"</blockquote>
                <em>{{ citation.author }}</em>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            citation: ''
        }
    },
    methods: {
        generateRandomQuote(citations) {
            let keys = Object.keys(citations);
            let author = keys[Math.floor(Math.random() *keys.length)];
            let quote = citations[author];
            return {"quote": quote, "author": author};
        }
    },
    created() {
        let citations = require('../citations.json');
        this.citation = this.generateRandomQuote(citations);
    },
}
</script>

<style scoped lang="sass">
    blockquote
        font-size: 1.3rem

    em
        padding-top: 12px
        font-weight: bolder
        font-size: 1.2rem
</style>