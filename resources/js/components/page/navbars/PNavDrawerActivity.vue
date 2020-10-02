<template>
    <div>
        <v-list>
            <v-list-item link :href="$tools.routes.addQueryStringToWebUrl('/p')">
                <v-list-item-icon>
                    <v-icon>mdi-arrow-left</v-icon>
                </v-list-item-icon>
                <v-list-item-title>All activities</v-list-item-title>
            </v-list-item>
            <v-skeleton-loader
                :loading="loadingActivities"
                transition="fade-transition"
                type="list-item">
                <div>
                    <v-list-group v-model="showActivities">
                        <template v-slot:activator>
                            <v-list-item-title>More for {{ resourceName }}</v-list-item-title>
                        </template>


                        <v-list-item v-for="activity in activities" :key="activity.id" link
                                     :href="$tools.routes.addQueryStringToWebUrl('/p/' + activity.slug)">
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
            let role = (this.$tools.environment.authentication.hasRole() ? this.$tools.environment.authentication.getRole() : null);
            let group = (this.$tools.environment.authentication.hasGroup() ? this.$tools.environment.authentication.getGroup() : null);
            let user = (this.$tools.environment.authentication.hasUser() ? this.$tools.environment.authentication.getUser() : null);

            let method = 'for';

            if (this.$tools.environment.authentication.admin()) {
                method += 'Admin';
            }
            if (role !== null) {
                method += 'Role';
            } else if (group !== null) {
                method += 'Group';
            } else {
                method += 'User';
            }

            return this.$api.activities()[method](user, group, role);
        }
    },

    computed: {
        resourceName() {
            if (this.hasRole) {
                return this.role.data.role_name + ' of ' + this.group.data.name;
            }
            if (this.hasGroup) {
                return 'membership to ' + this.group.data.name;
            }
            return 'you';
        }
    }
}
</script>

<style scoped>

</style>
