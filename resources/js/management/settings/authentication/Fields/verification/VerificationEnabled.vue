<template>
    <div>
        <b-form-group
            id="verification-enabled-group"
            description="Do users need to verify their email before registration is complete?"
            label-for="verification-enabled"
            label-size="lg"
        >
            <b-form-checkbox :checked="value" @change="updateAttribute" name="verification-enabled" switch>
                {{ statusText }}
            </b-form-checkbox>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "VerificationEnabled",

        props: {},

        data() {
            return {
                value: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.authentication.verification.required, false)
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load current verification'));
        },

        methods: {
            updateAttribute(verification) {
                this.$emit('input', verification);
                if(verification !== this.value) {
                    console.log(verification);
                    this.value = verification;
                    this.$api.settings().set(window.settingKeys.authentication.verification.required, true)
                        .then(response => this.$notify.success('Updated the registration verification.'))
                        .catch(error => this.$notify.alert('Could not update the registration verification.'));
                }
            }
        },

        computed: {
            statusText() {
                if(this.value) {
                    return 'Verification required';
                }
                return 'Verification not required';
            }
        }
    }
</script>

<style scoped>

</style>
