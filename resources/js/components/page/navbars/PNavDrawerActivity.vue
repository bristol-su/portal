<template>
    <div>
        <v-list>
            <v-skeleton-loader
                :loading="loadingActivities"
                transition="fade-transition"
                type="list-item">
                <div>
                    <v-list-group v-model="showActivities">
                        <template v-slot:activator>
                            <v-list-item-title>More for {{resourceName}}</v-list-item-title>
                        </template>


                        <v-list-item v-for="activity in activities" :key="activity.id" link :href="addQueryToUrl('/p/' + activity.slug)">
                            <v-list-item-title>{{ activity.name }}</v-list-item-title>
                        </v-list-item>

                    </v-list-group>
                </div>
            </v-skeleton-loader>
        </v-list>
    </div>
</template>

<script>
export default {
    name: "PNavDrawerActivity",

    props: {

    },

    data() {
        return {
            activities: [],
            loadingActivities: false,
            showActivities: true
        }
    },

    created() {
        this.loadActivities();
    },

    methods: {
        addQueryToUrl(url) {
            let params = {};
            if(this.hasUser) {
                params.u = this.user.id;
            }
            if(this.hasGroup) {
                params.g = this.group.id;
            }
            if(this.hasRole) {
                params.r = this.role.id;
            }
            return url + '?' + Object.keys(params).map(param => param + '=' + params[param]).join('&');
        },
        loadActivities() {
            this.loadingActivities = true;
            this.getActivities()
                .then(response => this.activities = response.data)
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.loadingActivities = false)
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
        user() {
            if (this.hasUser) {
                return window.portal.user;
            }
            return null;
        },
        group() {
            if (this.hasGroup) {
                return window.portal.group;
            }
            return null;
        },
        role() {
            if (this.hasRole) {
                return window.portal.role;
            }
            return null;
        },
        resourceName() {
            if(this.hasRole) {
                return this.role.data.role_name + ' of ' + this.group.data.name;
            }
            if(this.hasGroup) {
                return 'membership to ' + this.group.data.name;
            }
            return 'you';
        }
    }
}
</script>

<style scoped>

</style>
