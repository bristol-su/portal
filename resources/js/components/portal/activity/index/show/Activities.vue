<template>
    <div>

        <activity-group
            class="activity-group"
            :activities="userActivity"
            :admin="admin"
            type="user"
            :resource-id="userId"
            :url="{'u': userId}">

        </activity-group>

        <activity-group
            class="activity-group"
            v-for="(groupActivitySet, groupId) in groupActivities"
            :key="'group:' + groupId"
            :activities="groupActivitySet"
            type="group"
            :resource-id="groupId"
            :admin="admin"
            :url="{'u': userId, 'g': groupId}">

        </activity-group>

        <activity-group
            class="activity-group"
            v-for="(roleActivitySet, roleId) in roleActivities"
            :key="'role:' + roleId"
            :activities="roleActivitySet"
            type="role"
            :resource-id="roleId"
            :admin="admin"
            :url="{'u': userId, 'g': getGroupId(roleId), 'r': roleId}">

        </activity-group>

    </div>
</template>

<script>
    import ActivityGroup from './ActivityGroup';
    export default {
        name: "Activities",
        components: {ActivityGroup},
        props: {
            activities: {
                required: true,
                type: Object
            },
            admin: {
                default: false,
                type: Boolean
            },
            userId: {
                required: true,
            },
            roleGroup: {
                required: false,
                type: Object,
                default: function() {
                    return {};
                }
            }
        },

        data() {
            return {}
        },

        methods: {
            getGroupId(roleId) {
                if(this.roleGroup.hasOwnProperty(roleId)) {
                    return this.roleGroup[roleId];
                }
            }
        },

        computed: {
            userActivity() {
                return this.activities.user

            },
            groupActivities() {
                return this.activities.group

            },
            roleActivities() {
                return this.activities.role
            }
        }
    }
</script>

<style scoped>
    .activity-group {
        padding: 10px;
    }

</style>
