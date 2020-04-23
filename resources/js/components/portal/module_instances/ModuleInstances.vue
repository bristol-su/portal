<template>
    <b-row>
        <b-col
            cols="12"
            class="padded"
             :key="key"
            v-for="key in Object.keys(groupedModules)">
            <module-instance-group
                :activity="activity"
                :admin="admin"
                :evaluation="evaluation"
                :heading="getHeadingFor(key)"
                :module-instances="groupedModules[key]">

            </module-instance-group>
        </b-col>
    </b-row>
</template>

<script>
    import ModuleInstance from './ModuleInstance';
    import ModuleInstanceGroup from './ModuleInstanceGroup';
    export default {
        name: "ModuleInstances",
        components: {ModuleInstanceGroup, ModuleInstance},
        props: {
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
            },
            groupings: {
                required: true,
                type: Array
            }
        },

        methods: {
            getHeadingFor(key) {
                if(key === 'empty') {
                    return null;
                }
                const group = this.groupings.find(grouping => grouping.id === parseInt(key));
                if(group) {
                    return group.heading;
                }
                return null;
            }
        },

        computed: {
            moduleInstances() {
                return this.activity.module_instances;
            },
            groupedModules() {
                return this.moduleInstances.reduce((grouped, moduleInstance) => {
                    const groupingId = ( moduleInstance.grouping_id || 'empty' );
                    grouped[groupingId] = (grouped[groupingId] || []).concat(moduleInstance);
                    return grouped;
                }, {});
            }
        }

    }
</script>

<style scoped>
    .padded {
        padding: 5px;
    }
</style>
