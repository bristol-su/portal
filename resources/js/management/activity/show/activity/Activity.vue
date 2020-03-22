<template>
    <div>
        <data-item title="Name">
            <activity-name :activity="activity"></activity-name>
        </data-item>
        <data-item title="Description">
            <activity-description :activity="activity"></activity-description>
        </data-item>
        <data-item title="Type">
            {{activity.type}}
        </data-item>
        <data-item title="Url">
            <a :href="url">{{url}}</a>
        </data-item>
        <data-item title="Active">
            <activity-active-from-to :activity="activity"></activity-active-from-to>
        </data-item>
        <data-item title="Progress">
            <a :href="'/activity/' + activity.id + '/progress'">
                <b-button size="xs">Click here to see progress</b-button>
            </a>
        </data-item>
        <data-item title="Enabled">
            <b-form-checkbox switch size="lg" v-model="enabled">{{enabledText}}</b-form-checkbox>
        </data-item>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    import ActivityName from './Labels/ActivityName';
    import ActivityDescription from './Labels/ActivityDescription';
    import ActivityActiveFromTo from './Labels/ActivityActiveFromTo';
    export default {
        name: "Activity",
        components: {ActivityActiveFromTo, ActivityDescription, ActivityName, DataItem},
        props: {
            activity: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                enabled: true
            }
        },

        created() {
            this.enabled = this.activity.enabled;
        },

        watch: {
            enabled() {
                this.changeStatus();
            }
        },

        methods: {
            changeStatus() {
                if(this.enabled !== this.activity.enabled) {
                    this.$api.activity().update(this.activity.id, {enabled: this.enabled})
                        .then(response => {
                            this.$notify.success('Updated enabled status');
                            window.location.reload();
                        })
                        .catch(error => this.$notify.alert('Could not update activity status'));
                }
            }
        },

        computed: {
            url() {
                return process.env.MIX_APP_URL + '/p/' + this.activity.slug;
            },
            enabledText() {
                return (this.enabled ? 'Enabled': 'Disabled');
            }
        }
    }
</script>

<style scoped>

</style>
