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
                    <b-table-simple responsive striped hover v-for="(modules, group) in groupedModules" :key="group">
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
                                        <module-instance-group-select :groupings="groupings" @update="updateGroupingId(module.id, $event.grouping_id)">
                                        </module-instance-group-select>
                                        <module-instance-order-changer @down="updatePosition(module.id, module.order - 1)" @up="updatePosition(module.id, module.order + 1)">
                                        </module-instance-order-changer>
                                    </div>
                                </b-td>
                                <b-td>
                                    <a :href="'/activity/' + activity.id + '/module-instance/' + module.id"><b-button variant="primary">View</b-button></a>
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
    export default {
        name: "Index",
        components: {ModuleInstanceOrderChanger, ModuleInstanceGroupSelect},
        props: {
            activity: {
                required: true,
                type: Object
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
                console.log(moduleId, groupingId, 'grp')

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
                    .then(this.updatingModuleInstancePosition = true)

                console.log('Updating ' + moduleId + ' to group ' + groupingId);
            },
            updatePosition(moduleId, position) {
                console.log(moduleId, position, 'Test')
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
                .then(this.updatingModuleInstancePosition = true)
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
                        order: module.order
                    }
                });
            },
            loading() {
                return this.loadingGroupings || this.loadingModuleInstances
                    || this.updatingModuleInstanceGroup || this.updatingModuleInstancePosition;
            },
            groupedModules() {
                return this.formattedModules.reduce((objectsByKeyValue, obj) => {
                    const value = obj['group'];
                    objectsByKeyValue[value] = (objectsByKeyValue[value] || []).concat(obj);
                    return objectsByKeyValue;
                }, {});
            }
        }

    }
</script>

<style scoped>

</style>
