<template>
    <div>
        <vue-form-generator :schema="actionInstance.action_schema.schema" :model="model" :options="actionInstance.action_schema.options">
        </vue-form-generator>

        <b-button variant="success" @click="saveActionInstanceFields">Save Action</b-button>
    </div>

</template>

<script>
    import VueFormGenerator from 'vue-form-generator'
    import axios from 'axios';

    export default {
        name: "MapFields",

        props: {
            actionInstance: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                model: {},
                actionInstanceFields: []
            }
        },

        created() {
            this.model = VueFormGenerator.schema.createDefaultObject(this.actionInstance.action_schema.schema, {});
        },

        methods: {
            saveActionInstanceFields() {
                let promises = [];
                Object.keys(this.model).forEach(key => {
                    let fieldId = this.fieldId(key);
                    if(fieldId === false) {
                        promises.push(this.$api.actionInstanceField().create(this.formatData(key, this.model[key])));
                    } else {
                        promises.push(this.$api.actionInstanceField().update(fieldId, this.formatData(key, this.model[key])));
                    }
                });

                axios.all(promises)
                    .then(responses => {
                        responses.forEach(response => this.actionInstanceFields.push(response.data));
                        this.$notify.success('Settings saved. This action will now be triggered!')
                    })
                    .catch(error => this.$notify.alert('There was an error saving the settings: ' + error.message));
            },

            fieldId(key) {
                return false;
            },

            formatData(key, value) {
                return {
                    action_instance_id: this.actionInstance.id,
                    action_value: value,
                    action_field: key
                };
            }
        },

    }
</script>

<style scoped>

</style>
