<template>
    <div>
        <b-form-checkbox switch size="lg" v-model="enabled">{{enabledText}}</b-form-checkbox>
    </div>
</template>

<script>
    export default {
        name: "Enable",

        props: {
            moduleInstance: {
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
            this.enabled = this.moduleInstance.enabled;
        },

        watch: {
            enabled(enabled) {
                this.$api.moduleInstances().update(this.moduleInstance.id, {
                    enabled: enabled
                })
                    .then(response => this.$notify.success('Updated module status'))
                    .catch(error => this.$notify.alert('Could not update module status: ' + error.message));
            }
        },

        computed: {
            enabledText() {
                if(this.enabled) {
                    return 'Enabled';
                }
                return 'Disabled';
            }
        }
    }
</script>

<style scoped>

</style>
