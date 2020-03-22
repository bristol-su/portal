<template>
    <div>
        <data-item title="Complete when...">
            <completion-condition-name :completion-condition="completionConditionInstance"></completion-condition-name>
        </data-item>
        <data-item title="Description">
            <completion-condition-description :completion-condition="completionConditionInstance"></completion-condition-description>
        </data-item>
        <data-item title="Settings">
            <c-c-settings :completion-condition="completionConditionInstance" :module-alias="moduleInstance.alias"></c-c-settings>
        </data-item>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    import CompletionConditionName from './Labels/CompletionConditionName';
    import CompletionConditionDescription from './Labels/CompletionConditionDescription';
    import CCSettings from './Labels/CCSettings';
    export default {
        name: "CompletionConditionView",

        components: {CCSettings, CompletionConditionDescription, CompletionConditionName, DataItem},

        props: {
            moduleInstance: {
                required: true,
                type: Object
            }
        },

        data() {
            return {}
        },

        methods: {},

        computed: {
            completionConditionInstance() {
                return this.moduleInstance.completion_condition_instance;
            }
        }
    }
</script>

<style scoped>

</style>
