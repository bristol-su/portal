<template>
    <div>
        <data-item title="Active For">
            <logic-preview :logic-id="moduleInstance.active" :module-instance-id="moduleInstance.id"
                           attribute="active"></logic-preview>
        </data-item>
        <hr/>
        <data-item title="Visible For">
            <logic-preview :logic-id="moduleInstance.visible" :module-instance-id="moduleInstance.id"
                           attribute="visible"></logic-preview>
        </data-item>
        <hr/>
        <data-item title="Mandatory For" v-if="completableActivity">
            <logic-preview :logic-id="moduleInstance.mandatory" :module-instance-id="moduleInstance.id"
                           attribute="mandatory"></logic-preview>
        </data-item>
        <hr/>
        <data-item title="Completion" v-if="completableActivity">
            <div v-if="editable">
                <completion-condition-view
                    :module-instance="moduleInstance"></completion-condition-view>
                <b-button variant="secondary" @click="replaceCompletionConditionInstance = true">Replace</b-button>
            </div>
            <create-completion-condition v-else :module-instance="moduleInstance"></create-completion-condition>
        </data-item>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    import LogicPreview from "./LogicPreview";
    import CompletionConditionView from './CompletionConditionView';
    import CreateCompletionCondition from './Labels/CreateCompletionCondition';

    export default {
        name: "Behaviour",
        components: {CreateCompletionCondition, CompletionConditionView, LogicPreview, DataItem},
        props: {
            moduleInstance: {
                required: true,
                type: Object
            }
        },
        computed: {
            completableActivity() {
                return this.moduleInstance.activity.type !== 'open';
            },
            editable() {
                return this.moduleInstance.completion_condition_instance_id !== null && !this.replaceCompletionConditionInstance
            }
        },

        data() {
            return {
                replaceCompletionConditionInstance: false
            }
        }
    }
</script>

<style scoped>

</style>
