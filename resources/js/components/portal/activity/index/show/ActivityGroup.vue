<template>
    <div>
        <b-card>
            <template v-slot:header>
                <h4 class="mb-0">
                    <user-activity-title v-if="type === 'user'" :user-id="resourceId"/>
                    <group-activity-title v-if="type === 'group'" :group="group"/>
                    <role-activity-title v-if="type === 'role'" :role="role" :group="group"/>
                </h4>
            </template>
            <b-row>
                <b-col
                    v-for="activity in activities"
                    :key="activity.id" xs="12" sm="6" md="3">
                    <activity
                        :activity="activity"
                        :admin="admin"
                        :url="url">

                    </activity>
                </b-col>
            </b-row>
        </b-card>


    </div>
</template>

<script>
    import Activity from './Activity';
    import UserActivityTitle from './UserActivityTitle';
    import GroupActivityTitle from './GroupActivityTitle';
    import RoleActivityTitle from './RoleActivityTitle';
    export default {
        name: "ActivityGroup",
        components: {Activity, UserActivityTitle, GroupActivityTitle, RoleActivityTitle},
        props: {
            activities: {
                type: Array,
                default: function() {
                    return [];
                }
            },
            resourceId: {
                required: true
            },
            admin: {
                type: Boolean,
                default: false
            },
            type: {
                required: true,
                type: String
            },
            url: {
                required: true,
                type: Object,
                default() {
                    return {};
                }
            },
            roles: {
                required: false,
                type: Object,
                default: function() {
                    return {};
                }
            },
            groups: {
                required: false,
                type: Object,
                default: function() {
                    return {};
                }
            }
        },

        computed: {
            role() {
                if(this.type === 'role') {
                    return this.roles[this.resourceId];
                }
                return null;
            },

            group() {
                if(this.type === 'group') {
                    return this.groups[this.resourceId];
                }
                if(this.type === 'role') {
                    return this.groups[this.role.group_id];
                }
                return null;
            }
        }

    }
</script>

<style scoped>

</style>
