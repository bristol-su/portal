<template>
    <div>
        <div class="flex justify-end gap-2 self-end mb-2">
            <span>Actions: </span>
            <a :href="$tools.routes.basic.baseWebUrl() + '/activity/' + activity.id + '/module-instance/create'"
               class="text-primary hover:text-primary-dark">
                <svg v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                     class="h-6 w-6" content="Add Module" fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"/>
                </svg>
                <span class="sr-only">Add Module</span>
            </a>
            <a class="text-primary hover:text-primary-dark cursor-pointer" @click.prevent="$ui.modal.show('new-grouping')">
                <svg v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                     class="h-6 w-6" content="Add Section" fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                          stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"/>
                </svg>
                <span class="sr-only">Add Section</span>
            </a>
        </div>

        <p-modal id="move-to-grouping" title="Move Module">
            <p-select
                :selectOptions="groupOptions"
                id="grouping-switcher"
                label="Select group"
                tooltip="Select the group to move the module to."
                v-model="newGroupingId">
            </p-select>
            <p-button @click="moveToGrouping">Move</p-button>
        </p-modal>

        <p-modal id="new-grouping" title="New Section">
            <create-grouping :activity-id="activity.id" @close="$ui.modal.hide('new-grouping')"
                             @created="groupings.push($event)"></create-grouping>
        </p-modal>

        <p-modal id="edit-grouping" title="Edit Section">
            <create-grouping v-if="oldGroupingId" :activity-id="activity.id"
                             :old-grouping-header="getGroupingNameFromId(oldGroupingId)"
                             :old-grouping-id="oldGroupingId"
                             @close="$ui.modal.hide('edit-grouping')"
                             @updated="refreshGroupings"></create-grouping>
        </p-modal>

        <p-table
            :busy="$isLoading('loading-modules') || $isLoading('get-groupings')"
            :columns="fields"
            :deletable="canDelete"
            :items="tableModules"
            :viewable="true"
            @delete="deleteModule"
            @view="viewModule">

            <template #fullRow="{row}">
                <h3 class="font-semibold">
                    {{ row.group }}
                </h3>
            </template>
            <template #fullRowActions="{row}">
                <span v-if="row.group_id !== 0 && row.group_id !== '0'" class="flex justify-center space-x-4">
                    <a class="text-primary hover:text-primary-dark" href="#"
                       role="button"
                       @click.prevent="editGrouping(row.group_id)"
                       @keydown.enter.prevent="editGrouping(row.group_id)"
                       @keydown.space.prevent="editGrouping(row.group_id)">
                        <span>
                            <svg
                                v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                                class="h-6 w-6" content="Edit"
                                fill="none" stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"/>
                            </svg>
                            <span class="sr-only">Edit</span>
                        </span>
                    </a>
                    <span>
                        <span v-if="row._table && row._table.isDeleting"
                              :aria-busy="true"
                              class="text-danger hover:text-danger-dark">
                            <span>
                                <svg class="animate-spin h-6 w-6" fill="none"
                                     viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2"></circle>
                                    <path
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        fill="currentColor"></path>
                                </svg>
                                <span class="sr-only">Deleting</span>
                            </span>
                        </span>
                        <a v-else
                           class="text-danger hover:text-danger-dark"
                           href="#"
                           role="button"
                           @click.prevent="deleteGrouping(row.group_id)"
                           @keydown.enter.prevent="deleteGrouping(row.group_id)"
                           @keydown.space.prevent="deleteGrouping(row.group_id)">
                            <span>
                                <svg
                                    v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                                    class="h-6 w-6" content="Delete"
                                    fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"/>
                                </svg>
                                <span class="sr-only">Delete</span>
                            </span>
                        </a>
                    </span>

                    <a :disabled="row._table.isMovingUp" class="text-primary hover:text-primary-dark" href="#"
                       @click="moveGroupingUp(row.group_id)">
                        <span>
                            <svg v-if="row._table.isMovingUp" class="animate-spin h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="2"></circle>
                                <path
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    fill="currentColor"></path>
                            </svg>

                            <svg v-else
                                 v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                                 class="h-6 w-6" content="Move Up"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"/>
                            </svg>
                            <span class="sr-only">Move Up</span>
                        </span>
                    </a>

                    <a :disabled="row._table.isMovingUp" class="text-primary hover:text-primary-dark" href="#"
                       @click="moveGroupingDown(row.group_id)">
                        <span>
                            <svg v-if="row._table.isMovingDown" class="animate-spin h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="2"></circle>
                                <path
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    fill="currentColor"></path>
                            </svg>
                            <svg v-else
                                 v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                                 class="h-6 w-6" content="Move Down"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"/>
                            </svg>
                            <span class="sr-only">Move Down</span>
                        </span>
                    </a>
                </span>
            </template>
            <template #actions="{row}">
                <a :disabled="row._table.isMovingUp" class="text-primary hover:text-primary-dark" href="#"
                   @click="moveModuleUp(row.id)">
                    <span>
                        <svg v-if="row._table.isMovingUp" class="animate-spin h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="2"></circle>
                            <path
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                fill="currentColor"></path>
                        </svg>

                        <svg v-else
                             v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                             class="h-6 w-6" content="Move Up"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"/>
                        </svg>
                        <span class="sr-only">Move Up</span>
                    </span>
                </a>
                <a :disabled="row._table.isMovingDown" class="text-primary hover:text-primary-dark" href="#"
                   @click="moveModuleDown(row.id)">
                    <span>
                        <svg v-if="row._table.isMovingDown" class="animate-spin h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="2"></circle>
                            <path
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                fill="currentColor"></path>
                        </svg>
                        <svg v-else
                             v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                             class="h-6 w-6" content="Move Down"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"/>
                        </svg>
                        <span class="sr-only">Move Down</span>
                    </span>
                </a>
                <a :disabled="row._table.isMovingGroups" class="text-primary hover:text-primary-dark" href="#"
                   @click="moveToGroupingDialog(row)">
                    <span>
                        <svg v-if="row._table.isMovingGroups" class="animate-spin h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="2"></circle>
                            <path
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                fill="currentColor"></path>
                        </svg>
                        <svg v-else
                             v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                             class="h-6 w-6" content="Move"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 9l4-4 4 4m0 6l-4 4-4-4" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"/>
                        </svg>
                        <span class="sr-only">Move</span>
                    </span>
                </a>
            </template>
        </p-table>
    </div>
</template>

<script>
import CreateGrouping from './CreateGrouping';

export default {
    name: "Index",
    components: {CreateGrouping},
    props: {
        activity: {
            required: true,
            type: Object
        },
        canDelete: {
            required: false,
            type: Boolean,
            default: function () {
                return false;
            }
        }
    },

    data() {
        return {
            fields: [
                {label: 'Name', key: 'name'},
                {label: 'Description', key: 'description', truncateCell: 30},
                {label: 'Type', key: 'alias'},
                {label: 'Status', key: 'enabled'},
            ],
            modules: [],
            groupings: [],
            newGroupingId: null,
            movingModule: null,
            oldGroupingId: null
        }
    },

    created() {
        this.loadModules();
        this.loadGroupings();
    },

    methods: {
        loadModules() {
            this.$api.modules().getBelongingToActivity(this.activity.id, 'loading-modules')
                .then(response => this.modules = response.data)
                .catch(error => this.$notify.alert('Something went wrong getting the module instances: ' + error.message));
        },
        deleteModule(data) {
            this.$ui.confirm.delete('Deleting module', 'Are you sure you want to delete the module ' + data.name + '?')
                .then(() => {
                    this.$api.moduleInstances().delete(data.id, 'deleting-module-' + data.id)
                        .then((response) => {
                            this.$notify.success('Module successfully deleted.');
                            this.modules.splice(
                                this.modules.indexOf(this.modules.find(m => m.id === data.id)),
                                1
                            );
                        })
                        .catch(error => this.$notify.alert('Could not delete the Module: ' + error.message));
                })
        },
        viewModule(module) {
            window.location.href = '/activity/' + this.activity.id + '/module-instance/' + module.id;
        },
        loadGroupings() {
            this.$api.modules().getGroupings(this.activity.id, 'get-groupings')
                .then(response => this.groupings = response.data)
                .catch(error => this.$notify.alert('Something went wrong getting the module instance groups: ' + error.message));
        },
        editGrouping(groupingId) {
            this.oldGroupingId = groupingId;
            this.$ui.modal.show('edit-grouping');
        },
        deleteGrouping(groupingId) {
            this.$api.modules().deleteGrouping(groupingId, 'deleting-grouping-' + groupingId)
                .then(response => {
                    this.loadGroupings();
                    this.loadModules();
                })
        },
        refreshGroupings() {
            this.loadModules();
            this.loadGroupings();
        },
        moveModuleUp(moduleId) {
            this.$api.modules().moveUp(moduleId, 'moving-module-up-' + moduleId)
                .then(response => {
                    this.loadModules();
                })
        },
        moveModuleDown(moduleId) {
            this.$api.modules().moveDown(moduleId, 'moving-module-down-' + moduleId)
                .then(response => {
                    this.loadModules();
                })
        },
        moveGroupingUp(groupingId) {
            this.$api.modules().moveGroupingUp(groupingId, 'moving-grouping-up-' + groupingId)
                .then(response => {
                    this.loadGroupings();
                })
        },
        moveGroupingDown(groupingId) {
            this.$api.modules().moveGroupingDown(groupingId, 'moving-grouping-down-' + groupingId)
                .then(response => {
                    this.loadGroupings();
                })
        },
        getGroupingNameFromId(groupingId) {
            if (!groupingId || groupingId === 0) {
                return 'Ungrouped';
            }
            let grouping = this.groupings.find(grouping => grouping.id === groupingId);
            if (grouping !== undefined) {
                return grouping.heading;
            }
            return 'Could not find group';
        },
        moveToGroupingDialog(module) {
            this.movingModule = module;
            this.newGroupingId = module.grouping_id;
            this.$ui.modal.show('move-to-grouping');
        },
        moveToGrouping() {
            this.$ui.modal.hide('move-to-grouping');
            this.$api.moduleInstances().update(this.movingModule.id, {grouping_id: this.newGroupingId}, 'moving-groups-' + this.movingModule.id)
                .then(response => this.loadModules())
                .catch(error => this.$notify.alert('Could not move the module'));
        }
    },

    computed: {
        groupOptions() {
            let options = this.groupings.map(g => {
                return {id: g.id, value: g.heading};
            })
            options.unshift({id: null, value: '-- No Group --'});
            return options;
        },
        emptyGroups() {
            return this.groupings.filter(g => this.modules.filter(m => m.grouping_id === g.id).length === 0);
        },
        groupedModules() {
            let groupings = [];
            this.groupings.forEach(grouping => {
                groupings.push({id: grouping.id, modules: this.modules.filter(m => m.grouping_id === grouping.id)});
            })
            if(this.modules.filter(m => m.grouping_id === null).length > 0) {
                groupings.push({id: 0, modules: this.modules.filter(m => m.grouping_id === null)});
            }
            return groupings;
        },
        tableModules() {
            let groupsWithModules = this.groupedModules;

            let tableModules = [];
            groupsWithModules.forEach(groupWithModule => {
                tableModules.push({
                    _table: {
                        full: true,
                        isMovingUp: this.$isLoading('moving-grouping-up-' + groupWithModule.id),
                        isMovingDown: this.$isLoading('moving-grouping-down-' + groupWithModule.id)
                    },
                    group: this.getGroupingNameFromId(groupWithModule.id),
                    group_id: groupWithModule.id
                });
                let orderedModules = groupWithModule.modules.sort((a, b) => {
                    if (a.order === null && b.order === null) {
                        return 0;
                    }
                    if (a.order === null) {
                        return 1;
                    }
                    if (b.order === null) {
                        return -1;
                    }
                    return (a.order > b.order ? 1 : -1);
                });

                orderedModules.forEach(module => {
                    tableModules.push({
                        ...module,
                        _table: {
                            isDeleting: this.$isLoading('deleting-module-' + module.id),
                            isMovingUp: this.$isLoading('moving-module-up-' + module.id),
                            isMovingDown: this.$isLoading('moving-module-down-' + module.id),
                            isMovingGroups: this.$isLoading('moving-groups-' + module.id),
                        }
                    })
                })
            });

            return tableModules;
        },
    }

}
</script>

<style scoped>

</style>
