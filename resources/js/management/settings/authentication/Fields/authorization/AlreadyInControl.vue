<template>
    <div>
        <b-form-group
            id="already-in-control-group"
            description="Do users need to verify their email before registration is complete?"
            label-for="already-in-control"
            label-size="lg"
        >
            <b-form-checkbox :checked="value" @change="updateAttribute" name="already-in-control" switch>
                {{ statusText }}
            </b-form-checkbox>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "AlreadyInControl",

        data() {
            return {
                value: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.authentication.authorization.requiredAlreadyInControl, false)
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load current status of required in control'));
        },

        methods: {
            updateAttribute(required) {
                this.$emit('input', required);
                if(required !== this.value) {
                    this.value = required;
                    this.$api.settings().set(window.settingKeys.authentication.authorization.requiredAlreadyInControl, required)
                        .then(response => this.$notify.success('Updated the status of required in control.'))
                        .catch(error => this.$notify.alert('Could not update the status of required in control.'));
                }
            }
        },

        computed: {
            statusText() {
                if(this.value) {
                    return 'Must already be in control';
                }
                return 'Not required to be in control';
            }
        }
    }
</script>

<style scoped>

</style>
