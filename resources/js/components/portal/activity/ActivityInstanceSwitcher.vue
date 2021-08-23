<template>
    <div>
        <p-select
            :selectOptions="selectOptions"
            id="activity-instance-switcher"
            v-model="selectedActivityInstance">
        </p-select>

        <p-modal title="New run through" :open="showNewActivityInstanceModal" v-if="showNewActivityInstanceModal" @close="showNewActivityInstanceModal = false">
            <NewActivityInstance
                :activity-id="currentActivityInstance.activity_id"
                :resource-id="currentActivityInstance.resource_id"
                :resource-type="currentActivityInstance.resource_type">

            </NewActivityInstance>
        </p-modal>
    </div>
</template>

<script>
    import NewActivityInstance from './NewActivityInstance';
    import Url from 'domurl';

    export default {
        name: "ActivityInstanceSwitcher",
        components: {NewActivityInstance},
        props: {
            activityInstances: {
                required: true,
                type: Array,
                default: function () {
                    return [];
                }
            },
            currentActivityInstance: {
                required: true,
                type: Object,
            }
        },

        data() {
            return {
                selectedActivityInstance: null,
                showNewActivityInstanceModal: false
            }
        },

        watch: {
            selectedActivityInstance: function(newActivityInstance) {
                if(newActivityInstance.hasOwnProperty('value')) {
                    newActivityInstance = newActivityInstance.value;
                }
                if(newActivityInstance === 'add') {
                    this.showNewActivityInstanceModal = true;
                } else if(newActivityInstance !== this.currentActivityInstance.id) {
                    window.location.href = this.makeUrl(newActivityInstance);
                }
            }
        },

        mounted() {
            this.selectedActivityInstance = this.currentActivityInstance.id;
        },

        methods: {
            makeUrl(id) {
                let u = new Url;
                u.query.a = id;
                return u.toString();
            }
        },

        computed: {
            selectOptions() {
                let options = this.activityInstances.map(activityInstance => {
                    return {
                        id: activityInstance.id,
                        value: activityInstance.name
                    }
                })
                options.push({id: 'add', value: 'Add a new run through'})
                return options;
            }
        }
    }
</script>

<style scoped>

</style>
