<template>
    <div>
        <p-api-form :schema="formSchema" @submit="saveAction">
            <template #appendForm>
                <map-fields
                    v-if="actionInstance !== null"
                    :action-instance="actionInstance"
                ></map-fields>
            </template>
            <template #buttonText>{{actionInstance === null ? 'Create' : 'Update'}}</template>
        </p-api-form>
    </div>
</template>

<script>
    import MapFields from './MapFields';

    export default {
        name: "Create",

        components: {
            MapFields
        },

        props: {
            moduleInstance: {
                required: true,
                type: Object
            },
            module: {
                required: true,
                type: Object
            },
            actionInstance: {
                required: false,
                type: Object,
                default: null
            }
        },

        data() {
            return {
                actions: []
            }
        },

        created() {
            this.loadActions();
        },

        methods: {
            loadActions() {
                this.$api.action().index()
                    .then(response => this.actions = response.data)
                    .catch(error => this.$notify.alert('Could not load available actions: ' + error.message));
            },

            saveAction(data) {
                data.module_instance_id = this.moduleInstance.id;
                let promise;
                if(this.actionInstance === null) {
                    promise = this.$api.actionInstance().create(data)
                } else {
                    promise = this.$api.actionInstance().update(this.actionInstance.id, data);
                }
                promise
                    .then(response => this.actionInstance = response.data)
                    .catch(error => this.$notify.alert('Couldn\'t save your trigger: ' + error.message));
            }
        },

        computed: {
            triggerOptions() {
                return this.module.triggers.map(trigger => {
                    return {
                        id: trigger.event,
                        value: trigger.name
                    };
                });
            },

            actionOptions() {
                return this.actions.map(action => {
                    return {
                        id: action.class,
                        value: action.name
                    };
                });
            },

            formSchema() {
                let form = this.$tools.generator.form.newForm()
                    .withGroup(
                        this.$tools.generator.group.newGroup('Details')
                            .withField(
                                this.$tools.generator.field.text('name')
                                    .label('Name')
                                    .hint('A name for the action to help you remember what it does.')
                                    .tooltip('This should be a short title for the action which summarises what the action will do.')
                                    .value(this.actionInstance?.name)
                                    .required(true)
                            )
                            .withField(
                                this.$tools.generator.field.checkbox('should_queue')
                                    .label('Queue action?')
                                    .hint('Should the action run in the background? This helps with speed, and should be ticked if possible.')
                                    .value(this.actionInstance?.should_queue ?? true)
                            )
                            .withField(
                                this.$tools.generator.field.select('event')
                                    .setOptions(this.triggerOptions)
                                    .label('What should happen...')
                                    .hint('What should trigger the action?')
                                    .disabled(this.actionInstance !== null)
                                    .value(this.actionInstance?.event)
                            )
                            .withField(
                                this.$tools.generator.field.select('action')
                                    .setOptions(this.actionOptions)
                                    .label('...to run the action')
                                    .hint('What should happen when the action runs?')
                                    .disabled(this.actionInstance !== null)
                                    .value(this.actionInstance?.action)
                            )
                    )

                return form.generate().asJson();
            }
        }
    }
</script>

<style scoped>

</style>
