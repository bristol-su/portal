<template>
    <div>
        <b-card no-body>
            <b-tabs card>
                <b-tab title="Settings" active>
                    <data-item v-for="(val, key) in history.settings" :key="key" :title="key">{{val}}</data-item>
                </b-tab>
                <b-tab title="Available Fields">
                    <data-item v-for="(val, key) in history.event_fields" :key="key" :title="key">{{val}}</data-item>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>
</template>

<script>
    import DataItem from '../../../utilities/DataItem';

    export default {
        name: "ActionHistory",

        components: {DataItem},

        props: {
            history: {
                required: true,
                type: Object
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
