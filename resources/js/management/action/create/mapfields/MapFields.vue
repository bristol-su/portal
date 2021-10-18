<template>
    <div>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            <p-dynamic-form :schema="actionInstance.action_schema" v-model="model"></p-dynamic-form>

            <b-button variant="success" @click="saveActionInstanceFields">Save Action</b-button>
        </div>
    </div>

</template>

<script>
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
                actionInstanceFields: [],
                loading: true
            }
        },

        created() {
            this.$api.actionInstanceField().allThroughActionInstance(this.actionInstance.id)
                .then(response => {
                    this.actionInstanceFields = response.data;
                    let currentData = {};
                    this.actionInstanceFields.forEach(field => {
                        currentData[field.action_field] = field.action_value;
                    });
                    this.model = currentData;
                    this.loading = false;
                })
                .catch(error => this.$notify.alert('Could not load action instances'));
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
                        this.$emit('saved');
                    })
                    .catch(error => this.$notify.alert('There was an error saving the settings: ' + error.message));
            },

            fieldId(key) {
                let field = this.actionInstanceFields.filter(field => field.action_field === key);
                if(field.length === 0) {
                    return false;
                }
                return field[0].id;
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
