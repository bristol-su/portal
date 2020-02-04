<template>
    <div>
        <b-form-group
            id="already-in-data-group"
            description="Do users need to verify their email before registration is complete?"
            label-for="already-in-data"
            label-size="lg"
        >
            <b-form-checkbox :checked="value" @change="updateAttribute" name="already-in-data" switch>
                {{ statusText }}
            </b-form-checkbox>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "AlreadyInData",

        data() {
            return {
                value: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.authentication.authorization.requiredAlreadyInData, false)
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load current status of required in data'));
        },

        methods: {
            updateAttribute(required) {
                this.$emit('input', required);
                if(required !== this.value) {
                    this.value = required;
                    this.$api.settings().set(window.settingKeys.authentication.authorization.requiredAlreadyInData, required)
                        .then(response => this.$notify.success('Updated the status of required in data.'))
                        .catch(error => this.$notify.alert('Could not update the status of required in data.'));
                }
            }
        },

        computed: {
            statusText() {
                if(this.value) {
                    return 'Must already be in data';
                }
                return 'Not required to be in data';
            }
        }
    }
</script>

<style scoped>

</style>
