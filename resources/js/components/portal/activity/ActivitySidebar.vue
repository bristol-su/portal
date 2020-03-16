<template>
    <div>
        <b-list-group>
            <a :href="'/' + urlPrefix + '/' + activity.slug + '?' + queryString"
               :key="activity.id"
               v-for="activity in activities">
                <b-list-group-item
                    :active="isSelected(activity, false)">
                    {{activity.name}}
                </b-list-group-item>
            </a>
        </b-list-group>

    </div>
</template>

<script>
    export default {
        name: "PortalSidebar",

        props: {
            activities: {
                required: true,
                type: Array
            },
            currentActivity: {
                required: true,
                type: Object,
            },
            admin: {
                required: true,
                type: Boolean,
                default: false
            }
        },

        methods: {
            isSelected(activity) {
                return activity.id === this.currentActivity.id;
            }
        },

        computed: {
            urlPrefix() {
                return (this.admin ? 'a' : 'p' );
            },
            queryString() {
                return portal.queryString;
            }
        }
    }
</script>

<style scoped>

</style>
