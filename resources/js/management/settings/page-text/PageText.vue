<template>
    <div>
        <b-row>
            <b-col><h3>These settings are related to text that appears on the site</h3></b-col>
        </b-row>
        <b-row>
            <b-col>
                <landing></landing>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <footer-text></footer-text>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import Landing from './Landing';
    import FooterText from './FooterText';
    export default {
        name: "PageText",
        components: {FooterText, Landing},
        props: {},

        data() {
            return {}
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
