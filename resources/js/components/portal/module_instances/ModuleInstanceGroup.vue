<template>
    <div>
        <b-card class="module-instance-card">
            <template v-slot:header v-if="hasHeading">
                <h5>{{heading}}</h5>
            </template>
            <b-row>
                <b-col
                       v-for="moduleInstance in orderedAndEnabledModuleInstances"
                       :key="moduleInstance.id"
                        cols="4">
                    <module-instance
                        :module-instance="moduleInstance"
                        :evaluation="evaluationObject(moduleInstance.id)"
                        :activity="activity"
                        :admin="admin">

                    </module-instance>
                </b-col>

            </b-row>

        </b-card>

    </div>
</template>

<script>
    import ModuleInstance from './ModuleInstance';

    export default {
        name: "ModuleInstanceGroup",
        components: {ModuleInstance},
        props: {
            moduleInstances: {
                type: Array,
                required: true
            },
            heading: {
                type: String,
                required: false,
                default: ''
            },
            activity: {
                required: true,
                type: Object,
            },
            admin: {
                required: true,
                type: Boolean
            },
            evaluation: {
                required: false,
                default() {
                    return [];
                }
            }
        },

        methods: {
            evaluationObject(id) {
                return (this.evaluation[id] !== undefined
                    ? this.evaluation[id]
                    : {
                        active: false,
                        visible: false,
                        mandatory: false,
                    });
            },


        },

        computed: {
            orderedModuleInstances() {
                return this.moduleInstances.sort((a, b) => {
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
                });
            },
            hasHeading() {
                return this.heading !== null && this.heading !== '';
            },
            orderedAndEnabledModuleInstances() {
                return this.orderedModuleInstances.filter(moduleInstance => {
                    return moduleInstance.enabled && this.evaluationObject(moduleInstance.id).visible
                })
            }
        }
    }
</script>

<style scoped>
</style>
