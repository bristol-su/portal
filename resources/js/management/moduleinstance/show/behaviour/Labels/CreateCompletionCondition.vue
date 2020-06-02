<template>
    <div>
        <completion-condition :completion-conditions="conditions" @input="updateConditionId"></completion-condition>
    </div>
</template>

<script>
    import CompletionCondition from '../../../create/behaviour/CompletionCondition';
    export default {
        name: "CreateCompletionCondition",
        components: {CompletionCondition},
        props: {
            moduleInstance: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                conditions: []
            }
        },

        created() {
            this.loadConditions();
        },

        methods: {
            loadConditions() {
                this.$api.completionConditions().allForModule(this.moduleInstance.alias)
                    .then(response => this.conditions = response.data)
                    .catch(error => this.$notify.alert('Could not load available conditions: ' + error.message));
            },

            updateConditionId(id) {
                this.$api.moduleInstances().update(this.moduleInstance.id, {
                    completion_condition_instance_id: id
                })
                    .then(response => {
                        this.$notify.success('Saved new completion condition to module instance');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not save the new completion condition instance: ' + error.message));
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
