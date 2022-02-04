<template>
    <div>
        <div v-if="editing">

            <map-fields
                :action-instance="action"
                @saved="reloadPage"
            >
            </map-fields>

            <br/>
            <hr/>
            <br/>

            <available-event-fields :action-instance="action"></available-event-fields>

        </div>
        <div v-else>
            <data-item v-for="field in mappedFields" :key="field.id" :title="field.action_field">
                {{field.action_value}}
            </data-item>
            <span><b-button variant="secondary" @click="edit">Edit</b-button></span>
        </div>
    </div>
</template>

<script>
    import AvailableEventFields from '../../create/mapfields/AvailableEventFields';
    // import MapFields from '../../create/mapfields/MapFields';
    import DataItem from '../../../../utilities/DataItem';

    export default {
        name: "ActionSettings",
        components: {AvailableEventFields, DataItem},
        props: {
            action: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                newSettings: null,
                mappedFields: []
            }
        },

        mounted() {
            this.loadMappedFields();
        },

        methods: {
            loadMappedFields() {
                this.$api.actionInstanceField().allThroughActionInstance(this.action.id)
                    .then(response => this.mappedFields = response.data)
                    .catch(error => this.$notify.alert('Could not load settings: ' + error.message));
            },

            edit() {
                this.newSettings = this.action.settings;
                this.editing = true;
            },
            reloadPage() {
                window.location.reload();
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
