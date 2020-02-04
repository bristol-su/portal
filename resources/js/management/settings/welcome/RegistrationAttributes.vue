`<template>
    <div>
        <b-form-group
            id="registration-attributes-group"
            description="What information should the user be able to update?"
            label-for="registration-attributes"
            label-size="lg"
        >
            <b-list-group>

            <registration-attribute
                v-for="(attribute, key) in possibleAttributes"
                :key="key"
                :value="attribute"
                @input="updateAttribute(key, $event)"
                :attribute-key="key"></registration-attribute>

            </b-list-group>

        </b-form-group>
    </div>
</template>

<script>
    import RegistrationAttribute from './RegistrationAttribute';
    export default {
        name: "RegistrationAttributes",
        components: {RegistrationAttribute},
        data() {
            return {
                attributes: {},
                additionalAttributes: []
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.additional_attributes.user, '[]')
                .then(response => this.additionalAttributes = (response.data.value === '[]'?[]:response.data.value))
                .catch(error => this.$notify.alert('Could not load any additional attributes'));
            this.$api.settings().get(window.settingKeys.welcome.attributes, '{}')
                .then(response => this.attributes = (response.data.value === '{}'?{}:response.data.value))
                .catch(error => this.$notify.alert('Could not load current status'));
        },

        methods: {
            updateAttribute(key, attributes) {
                this.$set(this.attributes, key, attributes);
                this.$emit('input', this.attributes);
                console.log(this.attributes);
                this.$api.settings().set(window.settingKeys.welcome.attributes, this.attributes)
                    .then(response => this.$notify.success('Updated the status of additional attributes.'))
                    .catch(error => this.$notify.alert('Could not update the status of additional attributes.'));

            }
        },

        computed: {
            possibleAttributes() {
                let defaultSetting = {
                    visible: true, editable: true, required: false,
                };
                let possibleAttributes = {
                    email: (this.attributes.hasOwnProperty('email')?this.attributes.email:defaultSetting),
                    first_name: (this.attributes.hasOwnProperty('first_name')?this.attributes.first_name:defaultSetting),
                    last_name: (this.attributes.hasOwnProperty('last_name')?this.attributes.last_name:defaultSetting),
                    preferred_name: (this.attributes.hasOwnProperty('preferred_name')?this.attributes.preferred_name:defaultSetting),
                    dob: (this.attributes.hasOwnProperty('dob')?this.attributes.dob:defaultSetting),
                };
                this.additionalAttributes.forEach(attribute => {
                    possibleAttributes[attribute.key] = (this.attributes.hasOwnProperty(attribute.key)?this.attributes[attribute.key]:defaultSetting);
                });
                return possibleAttributes;
            }
        }
    }
</script>

<style scoped>

</style>
`
