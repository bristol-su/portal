<template>
    <div>
        <div v-if="errored">
            {{ error }}
        </div>
        <v-list v-else>
            <v-list-item link>
                <v-list-item-title>Go to Admin</v-list-item-title>
            </v-list-item>

            <v-divider inset></v-divider>

            <v-list-item link href="/p">
                <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item>

            <v-skeleton-loader
                :loading="loading"
                transition="fade-transition"
                type="list-item">
                <div>
                    <v-list-item v-if="user !== null" link :href="'/p?u=' + user.id">
                        <v-list-item-title>Services for you</v-list-item-title>
                    </v-list-item>
                </div>
            </v-skeleton-loader>

            <v-skeleton-loader
                :loading="loading"
                transition="fade-transition"
                type="list-item">
                <div>
                    <v-list-group v-if="groups.length > 0">
                        <template v-slot:activator>
                            <v-list-item-title>Memberships</v-list-item-title>
                        </template>


                        <v-list-item v-for="group in groups" :key="group.id" link :href="'/p?u=' + user.id + '&g=' + group.id">
                            <v-list-item-title>{{ group.data.name }}</v-list-item-title>
                        </v-list-item>

                    </v-list-group>
                </div>
            </v-skeleton-loader>

            <v-skeleton-loader
                :loading="loading"
                transition="fade-transition"
                type="list-item">
                <div>
                    <v-list-group v-if="roles.length > 0">
                        <template v-slot:activator>
                            <v-list-item-title>Committee Roles</v-list-item-title>
                        </template>


                        <v-list-item v-for="role in roles" :key="role.id" link :href="'/p?u=' + user.id + '&g=' + role.group_id + '&r=' + role.id">
                            <v-list-item-title>{{ role.data.role_name }} of {{ role.group.data.name }}</v-list-item-title>
                        </v-list-item>

                    </v-list-group>
                </div>
            </v-skeleton-loader>
        </v-list>
    </div>
</template>

<script>
export default {
    name: "PNavDrawerPortal",
    data() {
        return {
            user: null,
            groups: [],
            roles: [],
            loading: false,
            error: null
        }
    },
    created() {
        this.loadOwnedResources();
    },
    methods: {
        loadOwnedResources() {
            this.loading = true;
            this.$api.ownedResource().get()
                .then(response => {
                    this.user = response.data.user;
                    this.groups = response.data.groups;
                    this.roles = response.data.roles;
                })
                .catch(error => {
                    this.error = error.response.data.message
                })
                .finally(() => this.loading = false);
        }
    },
    computed: {
        errored() {
            return this.error !== null
        }
    }
}
</script>

<style scoped>

</style>
