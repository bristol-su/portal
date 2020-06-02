<template>
    <div>
        <b-row>
            <b-col lg="4" md="6" sm="12" v-if="canBeUser">
                <a :href="urlWithQuery({'u': user.id})">
                    <b-button variant="secondary">Your user account</b-button>
                </a>
            </b-col>
            <b-col :key="'group:' + group.id" lg="4" md="6" sm="12" v-for="group in groups">
                <a :href="urlWithQuery({'u': user.id, 'g': group.id})">
                    <b-button variant="secondary">Membership to {{group.data.name}}</b-button>
                </a>
            </b-col>
            <b-col :key="'role:' + role.id" lg="4" md="6" sm="12" v-for="role in roles">
                <a :href="urlWithQuery({'u': user.id, 'g': role.group.id, 'r': role.id})">
                    <b-button variant="secondary">Position of {{role.position.data.name}} of {{role.group.data.name}}</b-button>
                </a>
            </b-col>
        </b-row>
    </div>

</template>

<script>
    export default {
        props: {
            groups: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            roles: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            user: {
                type: Object,
                required: false
            },
            canBeUser: {
                type: Boolean,
                default: false
            },
            activity: {
                type: Object,
                required: true
            },
            redirectTo: {
                type: String,
                default: ''
            },
            admin: {
                type: Boolean,
                default: false
            }
        },

        methods: {
            urlWithQuery(query) {
                let url = new URL(this.redirectTo);
                Object.keys(query).forEach(key => url.searchParams.set(key, query[key]));
                return url.toString();
            }
        },

        computed: {
            redirectUrl() {
                // Must be the redurect URL with the correct query string appended
                if (this.redirectTo === null) {
                    return '/a/' + this.activity.slug;
                }
                return this.redirectTo;
            }
        }
    }
</script>

<style>

</style>
