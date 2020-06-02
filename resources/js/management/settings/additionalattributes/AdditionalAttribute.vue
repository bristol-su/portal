<template>
    <div>
        <b-card :title="attribute.name">
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "AdditionalAttribute",

        props: {
            attribute: {
                required: true,
                type: Object,
            }
        },

        data() {
            return {}
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
