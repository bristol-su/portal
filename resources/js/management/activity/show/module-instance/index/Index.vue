<template>
    <div>
        <div v-if="loading">
            Loading...
        </div>
        <div v-else>
            <b-row>
                <b-col v-if="loading">
                    <b-spinner></b-spinner>
                </b-col>
                <b-col v-else>
                    <b-table-simple responsive striped hover v-for="(modules, group) in orderedModules" :key="group">
                        <b-thead>
                            <b-tr>
                                <b-th colspan="4" class="text-center">{{ group }}</b-th>
                            </b-tr>
                        </b-thead>
                        <b-tbody>
                            <b-tr v-for="module in modules" :key="module.id">
                                <b-td>{{module.name}}</b-td>
                                <b-td>{{module.description}}</b-td>
                                <b-td>
                                    <div v-if="loading">
                                        <b-spinner></b-spinner>
                                    </div>
                                    <div v-else>
                                        <module-instance-group-select :disabled="loadingOrder" :groupings="groupings" @update="updateGroupingId(module.id, $event)" :grouping-id="module.grouping_id">
                                        </module-instance-group-select>
                                        <module-instance-order-changer :disabled="loadingOrder" @down="updatePosition(module.id, module.order - 1)" @up="updatePosition(module.id, module.order + 1)">
                                        </module-instance-order-changer>
                                    </div>
                                </b-td>
                                <b-td>
                                    <a :href="'/activity/' + activity.id + '/module-instance/' + module.id"><b-button variant="primary">View</b-button></a>
                                    <a @click.prevent="processDelete(module.id)"><b-button variant="danger" v-if="canDelete">Delete</b-button></a>
                                </b-td>
                            </b-tr>
                        </b-tbody>
                    </b-table-simple>
                </b-col>
            </b-row>
            <b-row>
                <b-col style="text-align: right; padding-right: 10px;">
                    <a :href="'/activity/' + activity.id + '/module-instance/create'">
                        <b-button variant="secondary">Add new module</b-button>
                    </a>
                </b-col>
            </b-row>

        </div>

    </div>
</template>

<script>
    import ModuleInstanceGroupSelect from "./ModuleInstanceGroupSelect";
    import ModuleInstanceOrderChanger from "./ModuleInstanceOrderChanger";

    export default {
        name: "Index",
        components: {ModuleInstanceOrderChanger, ModuleInstanceGroupSelect},
        props: {
            activity: {
                required: true,
                type: Object
            },
            canDelete: {
                required: false,
                type: Boolean,
                default: function() {
                    return false;
                }
            }
        },

        data() {
            return {
                modules: [],
                groupings: [],
                loadingModuleInstances: true,
                loadingGroupings: true,
                updatingModuleInstancePosition: false,
                updatingModuleInstanceGroup: false
            }
        },

        created() {
            this.loadModules();
            this.loadGroupings();
        },

        methods: {
            loadModules() {
                this.$api.modules().getBelongingToActivity(this.activity.id)
                    .then(response => this.modules = response.data)
                    .catch(error => this.$notify.alert('Something went wrong getting the module instances: ' + error.message))
                    .then(() => this.loadingModuleInstances = false);
            },
            loadGroupings() {
                this.loadingGroupings = true;
                this.$api.modules().getGroupings()
                    .then(response => this.groupings = response.data)
                    .catch(error => this.$notify.alert('Something went wrong getting the module instance groups: ' + error.message))
                    .then(() => this.loadingGroupings = false);
            },
            getGroupingNameFromId(groupingId) {
                if(!groupingId) {
                    return 'No group';
                }
                let grouping = this.groupings.find(grouping => grouping.id === groupingId);
                if(grouping !== undefined) {
                    return grouping.heading;
                }
                return 'Group not found';
            },
            updateGroupingId(moduleId, groupingId) {
                this.updatingModuleInstanceGroup = true;

                this.$api.moduleInstances().update(moduleId, {
                    grouping_id: groupingId
                })
                    .then(response => {
                        this.modules.splice(
                            this.modules.indexOf(
                                this.modules.find(m => m.id === moduleId)
                            ),
                            1, response.data
                        )
                    })
                    .catch(error => this.$notify.alert('There was an error updating the module instance: ' + error.message))
                    .then(this.updatingModuleInstanceGroup = false)

                console.log('Updating ' + moduleId + ' to group ' + groupingId);
            },
            updatePosition(moduleId, position) {
                this.updatingModuleInstancePosition = true;
                if(position < 0) {
                    position = 0;
                }
                this.$api.moduleInstances().update(moduleId, {
                    order: position
                })
                .then(response => {
                    this.modules.splice(
                        this.modules.indexOf(
                            this.modules.find(m => m.id === moduleId)
                        ),
                        1, response.data
                    )
                })
                .catch(error => this.$notify.alert('There was an error updating the module instance: ' + error.message))
                .then(this.updatingModuleInstancePosition = false)
            },
            processDelete(data) {
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this Module?', {
                    title: 'Deleting Activity',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Delete',
                    cancelTitle: 'Cancel',
                    footerClass: 'p-2',
                    hideHeaderClose: true,
                    centered: true
                })
                    .then(confirmed => {
                        if (confirmed) {
                            this.$api.moduleInstances().delete(data)
                                .then(
                                    this.$notify.success('Module successfully deleted.'),
                                    setTimeout(() => window.location.reload(), 3000)
                                )
                                .catch(error => this.$notify.alert('Could not delete the Module: ' + error.message));
                        } else {
                            this.$notify.info('No Module deleted');
                        }
                    })
                    .catch(error => this.$notify.alert('Could not delete the Module: ' + error.message));
            }
        },

        computed: {
            formattedModules() {
                return this.modules.map(module => {
                    return {
                        id: module.id,
                        name: module.name,
                        description: module.description,
                        group: this.getGroupingNameFromId(module.grouping_id),
                        order: module.order,
                        grouping_id: module.grouping_id
                    }
                });
            },
            loading() {
                return this.loadingGroupings || this.loadingModuleInstances;
            },
            loadingOrder() {
                return this.updatingModuleInstanceGroup || this.updatingModuleInstancePosition
            },
            groupedModules() {
                return this.formattedModules.reduce((objectsByKeyValue, obj) => {
                    const value = obj['group'];
                    objectsByKeyValue[value] = (objectsByKeyValue[value] || []).concat(obj);
                    return objectsByKeyValue;
                }, {});
            },
            orderedModules() {
                let groupedModules = this.groupedModules;
                Object.keys(groupedModules).map(group => {
                    groupedModules[group].sort((a, b) => {
                        if(a.order === null && b.order === null) {
                            return 0;
                        }
                        if(a.order === null) {
                            return 1;
                        }
                        if(b.order === null) {
                            return -1;
                        }
                        return (a.order > b.order ? 1 : -1);
                    })
                })
                return groupedModules;
            }
        }

    }
</script>

<style scoped>

</style>
