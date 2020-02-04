<template>
    <div>
        <a v-for="provider of providers"
           :key="provider"
           :href="'/login/provider/' + provider">
            <b-button pill class="social-button" :class="provider"><i :class="'fa fa-' + provider"/> {{provider | capitalized}}</b-button>
        </a>
    </div>
</template>

<script>
    export default {
        name: "SocialLogin",

        props: {
            providers: {
                type: Array,
                required: false,
                default: function() {
                    return [];
                }
            }
        },

        data() {
            return {}
        },

        methods: {},

        filters: {
            capitalized(val) {
                return val[0] ? `${val[0].toUpperCase()}${val.substring(1)}` : '';
            }
        },
        computed: {}
    }
</script>

<style scoped>

</style>
