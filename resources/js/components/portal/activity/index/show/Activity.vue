<template>
    <div>
        <a :href="activityUrl">
            <b-button variant="secondary">{{activity.name}}</b-button>
        </a>
    </div>
</template>

<script>
    export default {
        name: "Activity",

        props: {
            activity: {
                required: true,
                type: Object
            },
            admin: {
                default: false,
                type: Boolean
            },
            url: {
                type: Object,
                required: true,
                default: function() {
                    return {}
                }
            }
        },

        computed: {
            activityUrl() {
                return (this.admin?'/a/':'/p/')
                    + this.activity.slug + '?' + Object.keys(this.url).map(key => key + '=' + this.url[key]).join('&');
            }
        }
    }
</script>

<style scoped>

</style>
