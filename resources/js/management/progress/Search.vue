<template>
    <div>
        <b-row>
            <b-col style="text-align: right;">
                <b-button v-b-toggle.search-collapse variant="outline-info">Toggle Search</b-button>
            </b-col>
        </b-row>
        <b-collapse id="search-collapse">
            <b-row>
                <b-col md="12" lg="6">
                    <b-form-group
                        id="name-search-group"
                        label="Name:"
                        label-for="name-search"
                        description="The name of the participant (user/group/role)"
                    >
                        <activity-instances
                            :loading.sync="activityInstanceLoading"
                            :activity-id="activityId"
                            @set="parameters.activity_instances = $event"
                        >
                        </activity-instances>
                    </b-form-group>
                </b-col>
                <b-col sm="12" md="6" lg="3">
                    <b-form-group
                        id="lower-percentage-group"
                        label="Lower Percentage:"
                        label-for="lower-percentage"
                        description="The lower limit of percentages to show"
                    >
                        <b-form-input type="number" min="0.00" max="99.98" step="0.01"
                                      v-model="parameters.progress_above"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col sm="12" md="6" lg="3">
                    <b-form-group
                        id="upper-percentage-group"
                        label="Upper Percentage:"
                        label-for="upper-percentage"
                        description="The upper limit of percentages to show"
                    >
                        <b-form-input type="number" min="0.02" max="100" step="0.01"
                                      v-model="parameters.progress_below"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <exclusive-tags
                :options="moduleOptions"
                :first-selected="parameters.mandatory"
                :second-selected="parameters.optional"
                options-key="id">
                <template v-slot:default="{first,second}">
                    <b-row>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="mandatory-group"
                                label="Mandatory:"
                                label-for="mandatory"
                                description="Modules that are mandatory to be completed"
                            >
                                <module-instances :options="first" v-model="parameters.mandatory">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="optional-group"
                                label="Optional:"
                                label-for="optional"
                                description="Modules that are optional to be completed"
                            >
                                <module-instances :options="second" v-model="parameters.optional">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </template>
            </exclusive-tags>
            <exclusive-tags
                :options="moduleOptions"
                :first-selected="parameters.complete"
                :second-selected="parameters.incomplete"
                options-key="id">
                <template v-slot:default="{first,second}">
                    <b-row>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="complete-group"
                                label="Complete:"
                                label-for="complete"
                                description="Modules that have been complete"
                            >
                                <module-instances :options="first" v-model="parameters.complete">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="incomplete-group"
                                label="Incomplete:"
                                label-for="incomplete"
                                description="Modules that have not been completed"
                            >
                                <module-instances :options="second" v-model="parameters.incomplete">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </template>
            </exclusive-tags>
            <exclusive-tags
                :options="moduleOptions"
                :first-selected="parameters.visible"
                :second-selected="parameters.hidden"
                options-key="id">
                <template v-slot:default="{first,second}">
                    <b-row>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="visible-group"
                                label="Visible:"
                                label-for="visible"
                                description="Modules that are visible to participants"
                            >
                                <module-instances :options="first" v-model="parameters.visible">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="hidden-group"
                                label="Hidden:"
                                label-for="hidden"
                                description="Modules that are hidden from participants"
                            >
                                <module-instances :options="second" v-model="parameters.hidden">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </template>
            </exclusive-tags>
            <exclusive-tags
                :options="moduleOptions"
                :first-selected="parameters.active"
                :second-selected="parameters.inactive"
                options-key="id">
                <template v-slot:default="{first,second}">
                    <b-row>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="active-group"
                                label="Active:"
                                label-for="active"
                                description="Modules that are active to participants (can be clicked on)"
                            >
                                <module-instances :options="first" v-model="parameters.active">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                        <b-col md="12" lg="6">
                            <b-form-group
                                id="inactive-group"
                                label="Inactive:"
                                label-for="inactive"
                                description="Modules that are inactive to participants (may be greyed out)"
                            >
                                <module-instances :options="second" v-model="parameters.inactive">

                                </module-instances>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </template>
            </exclusive-tags>

            <b-button block variant="primary" @click="$emit('search')" :disabled="activityInstanceLoading">Search</b-button>

        </b-collapse>


    </div>
</template>

<script>
import ActivityInstances from './search/ActivityInstances';
import ModuleInstances from './search/ModuleInstances';
import ExclusiveTags from './search/ExclusiveTags';

export default {
    name: "Search",
    components: {ExclusiveTags, ModuleInstances, ActivityInstances},
    props: {
        value: {
            required: true,
            type: Object,
            default: function () {
                return {};
            }
        },
        moduleInstances: {
            required: false,
            type: Array,
            default: function () {
                return [];
            }
        },
        activityId: {
            required: true,
            type: Number
        }
    },

    data() {
        return {
            activityInstanceLoading: false
        }
    },

    computed: {
        parameters: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        },
        moduleOptions() {
            return this.moduleInstances;
        }
    }
}
</script>

<style scoped>

</style>
