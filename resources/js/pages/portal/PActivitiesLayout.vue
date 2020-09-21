<template>
    <div>
        <v-skeleton-loader
            :loading="loading"
            transition="scale-transition"
            type="card"
        >
            <v-row>
                <v-col v-for="activity in activities" :key="activity.id" cols="12" lg="4" md="6" xl="3">
                    <p-activity-card :activity="activity" :admin="admin" :query="query"></p-activity-card>
                </v-col>
            </v-row>
        </v-skeleton-loader>
    </div>
</template>

<script>

import PActivityCard from 'Components/PActivityCard';

export default {
    name: "PActivitiesLayout",
    components: {PActivityCard},
    data() {
        return {
            activities: [],
            loading: false
        }
    },
    props: {
        admin: {
            required: true,
            type: Boolean
        }
    },
    created() {
        this.loadActivities();
    },
    methods: {
        loadActivities() {
            this.loading = true;
            this.getActivities()
                .then(response => this.activities = response.data)
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.loading = false)
        },
        getActivities() {
            if (this.admin) {
                if (this.hasRole) {
                    return this.$api.activities().forAdminRole(this.userId, this.groupId, this.roleId);
                }
                if (this.hasGroup) {
                    return this.$api.activities().forAdminGroup(this.userId, this.groupId);
                }
                return this.$api.activities().forAdminUser(this.userId);
            }
            if (this.hasRole) {
                return this.$api.activities().forRole(this.userId, this.groupId, this.roleId);
            }
            if (this.hasGroup) {
                return this.$api.activities().forGroup(this.userId, this.groupId);
            }
            return this.$api.activities().forUser(this.userId);
        }
    },
    computed: {
        hasUser() {
            return window.portal.hasOwnProperty('user') && window.portal.user !== null && window.portal.user.hasOwnProperty('id');
        },
        hasGroup() {
            return window.portal.hasOwnProperty('group') && window.portal.group !== null && window.portal.group.hasOwnProperty('id');
        },
        hasRole() {
            return window.portal.hasOwnProperty('role') && window.portal.role !== null && window.portal.role.hasOwnProperty('id');
        },
        userId() {
            if (this.hasUser) {
                return window.portal.user.id;
            }
            return null;
        },
        groupId() {
            if (this.hasGroup) {
                return window.portal.group.id;
            }
            return null;
        },
        roleId() {
            if (this.hasRole) {
                return window.portal.role.id;
            }
            return null;
        },
        query() {
            let query = {};
            if (this.hasUser) {
                query.u = this.userId;
            }
            if (this.hasGroup) {
                query.g = this.groupId;
            }
            if (this.hasRole) {
                query.r = this.roleId;
            }
            return query;
        }
    }
}
</script>

<style scoped>

</style>
