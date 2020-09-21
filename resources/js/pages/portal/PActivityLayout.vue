<template>
    <div>
        <v-row>
            <v-col class="text-center">
                <v-card
                    class="mx-auto"
                >
                    <v-img
                        class="white--text align-end"
                        height="200px"
                        src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    >
                        <v-card-title>{{ activity.name }}</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">10% Complete</v-card-subtitle>

                </v-card>
            </v-col>
        </v-row>
        <v-skeleton-loader
            :loading="loading"
            transition="scale-transition"
            type="card"
        >
            <v-row>
                <v-col v-for="moduleInstance in moduleInstances" :key="moduleInstance.id" cols="12" lg="4" md="6"
                       xl="3">
                    <p-module-instance-card
                        :activity="activity"
                        :admin="admin"
                        :module-instance="moduleInstance">

                    </p-module-instance-card>
                </v-col>
            </v-row>
        </v-skeleton-loader>
    </div>
</template>

<script>

import PActivityCard from 'Components/PActivityCard';
import PModuleInstanceCard from 'Components/PModuleInstanceCard';

export default {
    name: "PActivityLayout",
    components: {PModuleInstanceCard, PActivityCard},
    data() {
        return {
            loading: false,
            moduleInstances: []
        }
    },
    props: {
        admin: {
            required: true,
            type: Boolean
        },
        activity: {
            required: true,
            type: Object
        }
    },
    created() {
        this.loadModuleInstances()
    },
    methods: {
        loadModuleInstances() {
            this.loading = true;
            this.getModuleInstances()
                .then(response => this.moduleInstances = response.data)
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.loading = false)
        },
        getModuleInstances() {
            let userId = (this.hasUser ? this.userId : null);
            let groupId = (this.hasGroup ? this.groupId : null);
            let roleId = (this.hasRole ? this.roleId : null);
            if (this.admin) {
                return this.$api.moduleInstances().adminEvaluation(this.activity.id, userId, groupId, roleId);
            }
            return this.$api.moduleInstances().userEvaluation(this.activity.id, this.activityInstanceId, userId, groupId, roleId);
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
        activityInstanceId() {
            if (window.portal.hasOwnProperty('activity_instance') && window.portal.activity_instance !== null && window.portal.activity_instance.hasOwnProperty('id')) {
                return window.portal.activity_instance.id;
            }
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
