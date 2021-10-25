<template>
    <div>
        <data-item title="Name">
            <logic-name :logic="logic"></logic-name>
        </data-item>
        <data-item title="Description">
            <logic-description :logic="logic"></logic-description>
        </data-item>
        <data-item title="Refresh Group">
            <b-button variant="secondary" @click="refreshLogic">Refresh</b-button>
        </data-item>
    </div>
</template>

<script>
    import DataItem from "../../../utilities/DataItem";
    import LogicName from './Labels/LogicName';
    import LogicDescription from './Labels/LogicDescription';
    export default {
        name: "Logic",
        components: {LogicDescription, LogicName, DataItem},
        props: {
            logic: {
                required: true,
                type: Object
            }
        },
        methods: {
            refreshLogic() {
                this.$api.logic().refresh(this.logic.id)
                    .then(response => this.$notify.success('The group will be updated in the background'))
                    .error(error => this.$notify.alert('Could not update the group: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
