<template>
    <div style="text-align: left;">
        <div>
            <b-card no-body>
                <b-tabs card pills vertical>
                    <b-tab active title="Action Information">
                        <data-item title="Name">
                            <action-name :action="action"></action-name>
                        </data-item>
                        <data-item title="Description">
                            <action-description :action="action"></action-description>
                        </data-item>
                    </b-tab>
                    <b-tab title="Settings">

                    </b-tab>
                </b-tabs>
            </b-card>
        </div>


    </div>
</template>

<script>
    import DataItem from '../../../utilities/DataItem';
    import ActionName from './Labels/ActionName';
    import ActionDescription from './Labels/ActionDescription';

    export default {
        name: "Show",

        components: {
            ActionDescription,
            ActionName,
            DataItem
        },

        props: {
            action: {
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
