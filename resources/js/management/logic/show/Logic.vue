<template>
    <div>
        <data-item title="Name">
            <logic-name :logic="logic"></logic-name>
        </data-item>
        <data-item title="Description">
            <logic-description :logic="logic"></logic-description>
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
        }
    }
</script>

<style scoped>

</style>
