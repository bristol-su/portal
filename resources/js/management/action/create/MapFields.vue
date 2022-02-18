<template>
    <div>
        <p-modal id="mapfields" title="Map Fields">

            <available-event-fields :action-instance="actionInstance"></available-event-fields>

            <p-api-form :schema="actionInstance.action_schema" @submit="mapFields" :initial-data="model" button-text="Save fields" :busy="$isLoading('mapping-fields')"></p-api-form>

        </p-modal>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            <p-button variant="secondary" type="button" @click="$ui.modal.show('mapfields')">
                Map Fields
            </p-button>
        </div>
    </div>

</template>

<script>
    import AvailableEventFields from './mapfields/AvailableEventFields';
    export default {
        name: "MapFields",
        components: {AvailableEventFields},
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
            this.loadActionInstances();
        },

        methods: {
            mapFields(data) {
                this.$api.actionInstanceField().setMany(this.actionInstance.id, data, 'mapping-fields')
                    .then(response => {
                        this.$notify.success('Settings saved. This action will now be triggered!')
                        this.loadActionInstances();
                        this.$ui.modal.hide('mapfields');
                    })
                    // .catch(error => this.$notify.alert('There was an error saving the settings: ' + error.message));
            },
            loadActionInstances() {
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
