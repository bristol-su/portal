<template>
    <div>
        <b-card sub-title="These fields may be used in the above settings." title="Available Event Fields">
            <b-list-group>
                <b-list-group-item :key="field"
                                   @click="copyToClipboard(field)"
                                    class="flex-column align-items-start"
                                   v-for="(metaData, field) in eventFields">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{metaData.label}}</h5>
                        <small class="text-muted" :ref="'click-to-copy-' + field">Click to Copy</small>
                    </div>

                    <p class="mb-1">
                        {{metaData.helptext}}
                    </p>

                    <small>{{field | formatAsField}}</small>
                </b-list-group-item>
            </b-list-group>

        </b-card>
    </div>
</template>

<script>
    export default {
        name: "AvailableEventFields",

        props: {
            actionInstance: {
                required: true,
                type: Object
            }
        },

        data() {
            return {}
        },

        filters: {
            formatAsField(val) {
                return '{{event:' + val + '}}';
            }
        },

        methods: {
            copyToClipboard(field) {
                let meta = this.eventFields[field];
                this.$clipboard(this.makeField(field));
                this.$notify.success('Field copied to clipboard: ' + meta.label);
            },

            makeField(val) {
                return '{{event:' + val + '}}';
            }
        },

        computed: {
            eventFields() {
                return this.actionInstance.event_fields;
            }
        }
    }
</script>

<style scoped>

</style>
