<template>
    <div>
        <data-item title="Name">
            <module-instance-name :module-instance="moduleInstance"></module-instance-name>
        </data-item>
        <data-item title="Description">
            <module-instance-description :module-instance="moduleInstance"></module-instance-description>
        </data-item>
        <data-item title="Module">
            {{moduleInstance.alias}}
        </data-item>
        <data-item title="Enabled">
            <enable :module-instance="moduleInstance"></enable>
        </data-item>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    import ModuleInstanceName from './Labels/ModuleInstanceName';
    import ModuleInstanceDescription from './Labels/ModuleInstanceDescription';
    import Enable from './Labels/Enable';
    export default {
        name: "ModuleInstance",
        components: {Enable, ModuleInstanceDescription, ModuleInstanceName, DataItem},
        props: {
            moduleInstance: {
                required: true,
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>
