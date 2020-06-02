<template>
    <div>
        <b-form-radio-group
            :checked="selectedAttribute"
            @input="updateAttribute"
            :options="possibleAttributes"
            name="radio-inline"
        ></b-form-radio-group>
    </div>
</template>

<script>
    export default {
        name: "RegistrationIdentifierSelection",

        props: {},

        data() {
            return {
                selectedAttribute: null,
                additionalAttributes: []
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.additional_attributes.user, '[]')
                .then(response => this.additionalAttributes = (response.data.value === '[]'?[]:response.data.value))
                .catch(error => this.$notify.alert('Could not load any additional attributes'));
            this.$api.settings().get(window.settingKeys.authentication.registration_identifier.identifier, null)
                .then(response => this.selectedAttribute = response.data.value)
                .catch(error => this.$notify.alert('Could not load any additional attributes'));
        },

        methods: {
            updateAttribute(attribute) {
                this.$emit('input', attribute);
                if(attribute !== this.selectedAttribute) {
                    this.selectedAttribute = attribute;
                    this.$api.settings().set(window.settingKeys.authentication.registration_identifier.identifier, attribute)
                        .then(response => this.$notify.success('Updated the registration identifier.'))
                        .catch(error => this.$notify.alert('Could not update the registration identifier.'));
                }
            }
        },

        computed: {
            possibleAttributes() {
                return [
                    {text: 'Email', value: 'email'},
                ].concat(this.additionalAttributes.map(attribute => {
                    return {text: attribute.name, value: attribute.key}
                }));
            }
        }
    }
</script>

<style scoped>

</style>
