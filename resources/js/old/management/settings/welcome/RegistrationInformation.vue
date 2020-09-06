<template>
    <div>
        <b-form-checkbox :checked="value" @change="updateAttribute" name="registration-information" switch>
            {{ statusText }}
        </b-form-checkbox>
    </div>
</template>

<script>
    export default {
        name: "RegistrationInformation",

        data() {
            return {
                value: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.welcome.fillInRegInformation, true)
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load current status'));
        },

        methods: {
            updateAttribute(fillInReg) {
                this.$emit('input', fillInReg);
                if(fillInReg !== this.value) {
                    this.value = fillInReg;
                    this.$api.settings().set(window.settingKeys.welcome.fillInRegInformation, fillInReg)
                        .then(response => this.$notify.success('Updated the status of additional information.'))
                        .catch(error => this.$notify.alert('Could not update the status of additional information.'));
                }
            }
        },

        computed: {
            statusText() {
                if(this.value) {
                    return 'The user will be given a chance to update their information.';
                }
                return 'The user will not be given a chance to update their information.';
            }
        }
    }
</script>

<style scoped>

</style>
