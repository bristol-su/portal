<template>
    <div>
        <b-form-input
            type="text"
            placeholder="e.g. required|min:6"
            :value="currentValidation"
            @input="updateAttribute"
        ></b-form-input>
    </div>
</template>

<script>
    export default {
        name: "RegistrationIdentifierValidation",

        props: {},

        data() {
            return {
                currentValidation: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.authentication.registration_identifier.validation, '')
                .then(response => this.currentValidation = response.data.value)
                .catch(error => this.$notify.alert('Could not load current validation'));
        },

        methods: {
            updateAttribute: _.debounce(function(validation) {
                this.$emit('input', validation);
                if(validation !== this.currentValidation) {
                    this.currentValidation = validation;
                    this.$api.settings().set(window.settingKeys.authentication.registration_identifier.validation, validation)
                        .then(response => this.$notify.success('Updated the registration validation.'))
                        .catch(error => this.$notify.alert('Could not update the registration validation.'));
                }
            }, 900)
        }
    }
</script>

<style scoped>

</style>
