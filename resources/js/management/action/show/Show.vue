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
                        <data-item title="Queueable">
                            <action-should-queue :action="action"></action-should-queue>
                        </data-item>
                    </b-tab>
                    <b-tab title="Settings">
                        <action-settings :action="action"></action-settings>
                    </b-tab>
                    <b-tab title="History">
                        <action-histories :action-instance="action"></action-histories>
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
    import ActionSettings from './Labels/ActionSettings';
    import ActionHistories from './ActionHistories';
    import ActionShouldQueue from './Labels/ActionShouldQueue';

    export default {
        name: "Show",

        components: {
            ActionShouldQueue,
            ActionHistories,
            ActionSettings,
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
