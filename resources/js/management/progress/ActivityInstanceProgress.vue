<template>
    <div>
        <div v-if="loading || !hasProgress">
            No progress found
        </div>
        <div v-else>
            <b-row>
                <b-col cols="6">
                    <h5><span style="font-weight: bold">{{ recentProgress.percentage }}% Complete</span></h5>
                </b-col>
                <b-col cols="6" style="text-align: right;">
                    <h5><span style="font-weight: bold">{{ fractionalCompletion }}</span></h5>
                </b-col>
            </b-row>
            <hr/>
            <b-row>
                <b-col style="text-align: center;">
                    <h5><span style="font-weight: bold">Completed Modules</span></h5>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" sm="12" md="6">
                    <b-row>
                        <b-col><span style="font-weight: bold;">Mandatory</span></b-col>
                    </b-row>
                    <b-row v-for="module in mandatoryCompleteModules" :key="module.id">
                        <b-col>
                            <activity-instance-progress-module-entry
                                :name="module.name"
                                :active="module.active"
                                :visible="module.visible"
                                :percentage="module.percentage">
                            </activity-instance-progress-module-entry>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col cols="12" sm="12" md="6">
                    <b-row>
                        <b-col><span style="font-weight: bold;">Optional</span></b-col>
                    </b-row>
                    <b-row v-for="module in optionalCompleteModules" :key="module.id">
                        <b-col>
                            <activity-instance-progress-module-entry
                                :name="module.name"
                                :active="module.active"
                                :visible="module.visible"
                                :percentage="module.percentage">
                            </activity-instance-progress-module-entry>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <br/>
            <b-row>
                <b-col style="text-align: center;">
                    <h5><span style="font-weight: bold">Incomplete Modules</span></h5>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" sm="12" md="6">
                    <b-row>
                        <b-col><span style="font-weight: bold;">Mandatory</span></b-col>
                    </b-row>
                    <b-row v-for="module in mandatoryIncompleteModules" :key="module.id">
                        <b-col>
                            <activity-instance-progress-module-entry
                                :name="module.name"
                                :active="module.active"
                                :visible="module.visible"
                                :percentage="module.percentage">
                            </activity-instance-progress-module-entry>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col cols="12" sm="12" md="6">
                    <b-row>
                        <b-col><span style="font-weight: bold;">Optional</span></b-col>
                    </b-row>
                    <b-row v-for="module in optionalIncompleteModules" :key="module.id">
                        <b-col>
                            <activity-instance-progress-module-entry
                                :name="module.name"
                                :active="module.active"
                                :visible="module.visible"
                                :percentage="module.percentage">
                            </activity-instance-progress-module-entry>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <hr/>
            <b-row>
                <b-col style="text-align: center;">
                    <h5><span style="font-weight: bold">Log</span></h5>
                </b-col>
                <b-col>
                    <span @click="calculateDiff">Refresh</span>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-table striped hover small responsive="true" sticky-header="700px" :items="diffOptions" :fields="diffFields">
                    </b-table>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
import {cloneDeep} from 'lodash';
import ActivityInstanceProgressModuleEntry from './ActivityInstanceProgressModuleEntry';
import moment from 'moment';

export default {
    name: "ActivityInstanceProgress",
    components: {ActivityInstanceProgressModuleEntry},
    props: {
        activityInstanceId: {
            required: false,
            type: Number,
            default: null
        },
        moduleInstances: {
            required: false,
            type: Array,
            default: function () {
                return [];
            }
        }
    },
    data() {
        return {
            progress: [],
            loading: false,
            diff: [],
            moduleNameCache: {},
            progressTimestampCache: {},
            humanReadableDiffTypes: {
                progress_complete: 'Activity Completion',
                progress_percentage: 'Activity Percentage',
                module_complete: 'Module Completion',
                module_percentage: 'Module Percentage',
                module_active: 'Module Active State',
                module_mandatory: 'Module Mandatory State',
                module_visible: 'Module Visible State',
                module_addition: 'Module Added',
                module_removal: 'Module Removed'
            },
            humanReadableDetails: {
                progress_complete: (diff) => `The activity changed from ${(diff.from ? 'complete' : 'incomplete')} to ${(diff.to ? 'complete' : 'incomplete')}.`,
                progress_percentage: (diff) => `The activity completion changed from ${diff.from}% to ${diff.to}% complete.`,
                module_complete: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' changed from ${(diff.from ? 'complete' : 'incomplete')} to ${(diff.to ? 'complete' : 'incomplete')}.`,
                module_percentage: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' completion percentage changed from ${diff.from}% to ${diff.to}%.`,
                module_active: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' changed from ${(diff.from ? 'active' : 'inactive')} to ${(diff.to ? 'active' : 'inactive')}.`,
                module_mandatory: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' changed from ${(diff.from ? 'mandatory' : 'optional')} to ${(diff.to ? 'mandatory' : 'optional')}.`,
                module_visible: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' changed from ${(diff.from ? 'visible' : 'hidden')} to ${(diff.to ? 'visible' : 'hidden')}.`,
                module_addition: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' was added.`,
                module_removal: (diff) => `The module '${this.moduleInstanceName(diff.module_id)}' was removed.`,
            },
            diffFields: [
                {key: 'type', label: 'Type', sortable: true},
                {key: 'details', label: 'Details'},
                {key: 'timestamp', label: 'Timestamp', sortable: true}
            ]
        }
    },
    watch: {
        title() {
            this.$emit('update:title', this.title);
        }
    },
    created() {
        if (this.activityInstanceId !== null) {
            this.loadActivityInstanceProgress();
        }
    },
    methods: {
        loadActivityInstanceProgress() {
            this.loading = true;
            this.$api.activityInstance().progress(this.activityInstanceId)
                .then(response => this.progress = response.data)
                .catch(error => this.$notify.alert('Could not load progress: ' + error.response.data.message))
                .finally(() => {
                    this.loading = false;
                    this.calculateDiff();
                });
        },
        moduleInstanceName(id) {
            if(this.moduleNameCache.hasOwnProperty(id)) {
                return this.moduleNameCache[id];
            }
            let moduleInstance = this.moduleInstances.filter(m => m.id === id);
            if (moduleInstance.length === 1) {
                this.moduleNameCache[id] = moduleInstance[0].name;
                return moduleInstance[0].name;
            }
            return 'N/A';
        },
        formatModuleInstanceProgress(moduleInstanceProgress) {
            return {
                id: moduleInstanceProgress.id,
                name: this.moduleInstanceName(moduleInstanceProgress.module_instance_id),
                visible: moduleInstanceProgress.visible === 1,
                active: moduleInstanceProgress.active === 1,
                percentage: parseFloat(moduleInstanceProgress.percentage)
            }
        },
        calculateDiff() {
            if (this.hasProgress && this.progress.length > 1) {
                let milestones = [];
                let progresses = cloneDeep(this.progress);
                progresses.reverse();
                let newState = this.calculateState(progresses[0]);
                progresses.shift();
                progresses.forEach(progress => {
                    let oldState = cloneDeep(newState);
                    newState = this.calculateState(progress);
                    let comparison = this.compareStates(oldState, newState, progress.id)
                    if(comparison.length > 0) {
                        milestones.push(comparison);
                    }
                })
                this.diff = milestones.flat(1);
            } else {
                return 'No log available';
            }

        },
        calculateState(progress) {
            let state = {
                complete: progress.complete === 1,
                percentage: parseFloat(progress.percentage),
                modules: {}
            }
            progress.module_instance_progress.forEach(moduleProgress => {
                state.modules[moduleProgress.module_instance_id] = {
                    complete: moduleProgress.complete === 1,
                    active: moduleProgress.active === 1,
                    mandatory: moduleProgress.mandatory === 1,
                    percentage: parseFloat(moduleProgress.percentage),
                    visible: moduleProgress.visible === 1,
                }
            })
            return state;
        },
        compareStates(oldState, newState, progressId) {
            let comparison = [];
            for(let attribute of ['complete', 'percentage']) {
                if(oldState[attribute] !== newState[attribute]) {
                    comparison.push({
                        type: 'progress_' + attribute,
                        progress_id: progressId,
                        from: oldState[attribute],
                        to: newState[attribute]
                    });
                }
            }
            for(let moduleId of Object.keys(newState.modules)) {
                if(oldState.modules.hasOwnProperty(moduleId)) {
                    for(let attribute of ['complete', 'percentage', 'active', 'mandatory', 'visible']) {
                        if(oldState.modules[moduleId][attribute] !== newState.modules[moduleId][attribute]) {
                            comparison.push({
                                type: 'module_' + attribute,
                                progress_id: progressId,
                                module_id: moduleId,
                                from: oldState.modules[moduleId][attribute],
                                to: newState.modules[moduleId][attribute]
                            });
                        }
                    }
                } else {
                    // Module has been added
                    comparison.push({
                        type: 'module_addition',
                        progress_id: progressId,
                        module_id: moduleId,
                    })
                }
            }
            Object.keys(oldState.modules)
                .filter(moduleId => !newState.modules.hasOwnProperty(moduleId))
                .forEach(moduleId => {
                    comparison.push({
                        type: 'module_removal',
                        progress_id: progressId,
                        module_id: moduleId,
                    })
                });

            return comparison;
        },
        getTimestampFromProgressId(progressId) {
            if(this.progressTimestampCache.hasOwnProperty(progressId)) {
                return this.progressTimestampCache[progressId];
            }
            let progress = this.progress.filter(p => p.id === progressId);
            if (progress.length === 1) {
                let timestamp = moment(progress[0].timestamp).format('D/M/YYYY H:m')
                this.progressTimestampCache[progressId] = timestamp;
                return timestamp;
            }
            return 'N/A';
        }
    },
    computed: {
        hasProgress() {
            return this.progress.length > 0;
        },
        title() {
            if (this.hasProgress) {
                return this.progress[0].activity_instance.participant_name;
            }
            return null;
        },
        recentProgress() {
            return this.progress[0];
        },
        recentModuleInstanceProgress() {
            return this.recentProgress.module_instance_progress
        },
        fractionalCompletion() {
            let completedModules = 0;
            this.recentModuleInstanceProgress.forEach(miProgress => {
                if (miProgress.complete === 1) {
                    completedModules++;
                }
            })
            return completedModules.toString() + '/' + this.recentModuleInstanceProgress.length;
        },
        mandatoryCompleteModules() {
            return this.recentModuleInstanceProgress.filter(m => m.mandatory === 1 && m.complete === 1).map(this.formatModuleInstanceProgress);
        },
        mandatoryIncompleteModules() {
            return this.recentModuleInstanceProgress.filter(m => m.mandatory === 1 && m.complete === 0).map(this.formatModuleInstanceProgress);
        },
        optionalCompleteModules() {
            return this.recentModuleInstanceProgress.filter(m => m.mandatory === 0 && m.complete === 1).map(this.formatModuleInstanceProgress);
        },
        optionalIncompleteModules() {
            return this.recentModuleInstanceProgress.filter(m => m.mandatory === 0 && m.complete === 0).map(this.formatModuleInstanceProgress);
        },
        diffOptions() {
            return this.diff.map(d => {
                console.log(d);
                return {
                    type: (this.humanReadableDiffTypes.hasOwnProperty(d.type) ? this.humanReadableDiffTypes[d.type] : 'N/A'),
                    details: (this.humanReadableDetails.hasOwnProperty(d.type) ? this.humanReadableDetails[d.type](d) : 'N/A'),
                    timestamp: this.getTimestampFromProgressId(d.progress_id)
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
