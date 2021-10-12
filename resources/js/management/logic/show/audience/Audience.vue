<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <b-table striped hover :fields="fields" :items="items">
                <template v-slot:cell(user)="data">
                    {{ formatUser(data.item.user) }}
                </template>
                <template v-slot:cell(can_access)="data">
                    <ul>
                        <li v-for="text in audienceCanAccessThrough(data.item)">
                            {{ text }}
                        </li>
                    </ul>
                </template>
            </b-table>
            <p-pagination :totalCount="totalAudienceCount" :pageSize="pageSize" :page="page"
                          @updatePageSize="pageSize = $event" @changePage="page = $event.page">

            </p-pagination>
        </div>
    </div>
</template>

<script>
import DataItem from "../../../../utilities/DataItem";

export default {
    name: "Audience",
    components: {DataItem},
    props: {
        logicId: {
            required: true,
            type: Number
        }
    },

    data() {
        return {
            audience: [],
            loading: false,
            fields: [
                {key: 'user', label: 'User'},
                {key: 'can_access', label: 'Ways involved in the logic'}
            ],
            pageSize: 15,
            page: 1,
            totalAudienceCount: 0
        }
    },

    created() {
        this.getAudience();
    },

    watch: {
        page: function(page) {
            this.getAudience();
        },
        pageSize: function(pageSize) {
            this.getAudience();
        }
    },

    methods: {
        getAudience() {
            this.loading = true;
            this.$api.logic().audience(this.logicId, this.pageSize, this.page)
                .then(response => {
                    this.audience = response.data.data;
                    this.totalAudienceCount = response.data.total;
                })
                .catch(error => console.log(error))
                .then(() => this.loading = false);
        },

        audienceCanAccessThrough(audienceItem) {
            let methods = [];
            if (audienceItem.canBeUser) {
                methods.push('Access through their user account')
            }
            methods = methods.concat(audienceItem.groups.map(group => {
                return 'Access through their membership to ' + group.data.name;
            }));
            methods = methods.concat(audienceItem.roles.map(role => {
                return 'Access through their role as ' + role.data.role_name + ' (' + role.position.data.name + ') to ' + role.group.data.name;
            }));
            return methods;
        },
        formatUser(user) {
            if (user.data.preferred_name !== null) {
                return user.data.preferred_name;
            }
            if (user.data.first_name !== null && user.data.last_name !== null) {
                return user.data.first_name + ' ' + user.data.last_name;
            }
            if (user.data.email !== null) {
                return user.data.email;
            }
            return user.id;
        }
    },

    computed: {
        items() {
            return this.audience.map(audience => {
                return {
                    user: audience.user,
                    groups: audience.groups,
                    roles: audience.roles,
                    canBeUser: audience.can_be_user
                }
            })
        },

    }

}
</script>

<style scoped>

</style>
