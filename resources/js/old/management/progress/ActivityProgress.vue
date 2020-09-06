<template>
    <b-container>
        <b-row>
            <b-col>
                <search
                    v-model="searchParameters"
                    :module-instances="moduleInstances"
                    :activity-id="activityId"
                    @search="$refs['progress-table'].refresh()"></search>
            </b-col>
        </b-row>
        <b-row>
            <b-col style="text-align: right;">
                <b-button @click="updateProgress" variant="outline-dark" small>Update Progress</b-button>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-table
                    small
                    :fields="tableFields"
                    :items="progressProvider"
                    no-provider-filtering
                    :per-page="perPage"
                    :current-page="currentPage"
                    sort-by="percentage"
                    ref="progress-table"
                    id="progress-table">
                    <template v-slot:cell(complete)="data">
                        <ul v-if="data.item.complete.length > 0">
                            <li v-for="miProgress of data.item.complete"
                                :class="{mandatory: data.item.mandatory.includes(miProgress.module_instance_id)}">
                                {{ moduleInstanceName(miProgress.module_instance_id) }}
                            </li>
                        </ul>
                        <div v-else>
                            ---
                        </div>
                    </template>
                    <template v-slot:cell(incomplete)="data">
                        <ul v-if="data.item.incomplete.length > 0">
                            <li v-for="miProgress of data.item.incomplete"
                                :class="{mandatory: data.item.mandatory.includes(miProgress.module_instance_id)}">
                                {{ moduleInstanceName(miProgress.module_instance_id) }}
                            </li>
                        </ul>
                        <div v-else>
                            ---
                        </div>
                    </template>
                    <template v-slot:cell(view)="data">
                        <b-button size="sm" variant="outline-dark" @click="showModal(data.item.activity_instance_id)">View</b-button>
                    </template>
                    <template v-slot:table-busy>
                        <div class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                </b-table>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="progress-table"
                    first-number
                    last-number
                    align="fill"
                    pills
                ></b-pagination>
            </b-col>
        </b-row>

        <b-modal id="progress-modal" size="lg" scrollable cancel-disabled ref="progress-modal" :title="modalTitle + ' - ' + activityName">
            <activity-instance-progress
                :activity-instance-id="visibleActivityInstanceId"
                @update:title="modalTitle = $event"
                :moduleInstances="moduleInstances">

            </activity-instance-progress>
        </b-modal>
    </b-container>
</template>

<script>
import Search from './Search';
import moment from 'moment';
import ActivityInstanceProgress from './ActivityInstanceProgress';

export default {
    name: "Progress",
    components: {ActivityInstanceProgress, Search},
    props: {
        activityId: {
            required: true,
            type: Number
        },
        activityName: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            loadedModuleInstances: false,
            moduleInstances: [],
            searchParameters: {
                activity_instances: [],
                progress_above: 0.00,
                progress_below: 100.00,
                active: [],
                inactive: [],
                visible: [],
                hidden: [],
                complete: [],
                incomplete: [],
                mandatory: [],
                optional: [],
            },
            currentPage: 1,
            perPage: 10,
            totalRows: 0,
            tableFields: [
                {key: 'name', label: 'Name', sortable: true},
                {key: 'percentage', label: 'Progress', sortable: true},
                {key: 'complete', label: 'Complete'},
                {key: 'incomplete', label: 'Incomplete'},
                {key: 'last_updated', label: 'Last Updated'},
                {key: 'view', label: ''},
            ],
            visibleActivityInstanceId: null,
            modalTitle: 'Please refresh the page'
        }
    },

    methods: {
        loadModuleInstances() {
            return new Promise((resolve, reject) => {
                if (!this.loadedModuleInstances) {
                    this.$api.modules().getBelongingToActivity(this.activityId)
                        .then(response => {
                            this.moduleInstances = response.data;
                            resolve();
                        })
                        .catch(error => {
                            this.$notify.alert('Could not load module names: ' + error.response.data.message)
                            reject(error)
                        })
                        .finally(() => this.loadedModuleInstances = true);
                } else {
                    resolve();
                }
            });
        },
        showModal(activityInstanceId) {
            this.visibleActivityInstanceId = activityInstanceId;
            this.$refs['progress-modal'].show();
        },
        moduleInstanceName(id) {
            let moduleInstance = this.moduleInstances.filter(m => m.id === id);
            if (moduleInstance.length === 1) {
                return moduleInstance[0].name;
            }
            return 'N/A';
        },
        progressProvider({currentPage, perPage, sortBy, sortDesc}, callback) {
            let parameters = this.searchParameters;
            parameters.page = currentPage;
            parameters.per_page = perPage;
            parameters.sort_by = sortBy;
            parameters.sort_desc = (sortDesc ? 1 : 0);
            this.loadModuleInstances()
                .then(response => {
                    this.$api.progress().index(this.activityId, parameters)
                        .then(response => {
                            this.totalRows = response.data.total;
                            callback(response.data.data.map(progress => {
                                return {
                                    activity_instance_id: progress.activity_instance_id,
                                    name: progress.activity_instance.participant_name,
                                    percentage: progress.percentage + "%",
                                    last_updated: moment(progress.timestamp).fromNow(),
                                    complete: progress.module_instance_progress.filter(p => p.complete === 1),
                                    incomplete: progress.module_instance_progress.filter(p => p.complete === 0),
                                    mandatory: progress.module_instance_progress.filter(p => p.mandatory === 1).map(p => p.module_instance_id)
                                }
                            }));
                        })
                        .catch(error => {
                            this.$notify.alert('Could not load the progress: ' + error.response.data.message);
                            callback([]);
                        })
                })

            return null;
        },
        updateProgress() {
            this.$bvModal.msgBoxConfirm('Are you sure you want to take a progress snapshot? This may take up to 10 minutes to generate. Please do not use this feature more than a few times a day.', {
                title: 'Take a progress snapshot?'
            })
                .then(value => {
                    if (value) {
                        this.$api.progress().takeSnapshot(this.activityId)
                            .then(response => this.$notify.success('Progress is being updated'))
                            .catch(error => this.$notify.alert('Could not update progress: ' + error.response.data.message));
                    }
                })
                .catch(err => {
                })
        }
    }
}
</script>

<style scoped>
.mandatory {
    color: orangered;
}
</style>
