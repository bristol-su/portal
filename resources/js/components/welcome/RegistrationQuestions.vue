<template>
    <div>
        <b-form-group
            v-if="isAttributeVisible('first_name')"
            description="Let us know your first name."
            id="first-name-group"
            label="Enter your first name"
            label-cols-lg="3"
            label-cols-sm="4"
            label-for="first-name"
        >
            <b-form-input
                :disabled="!isAttributeEditable('first_name')"
                :required="isAttributeRequired('first_name')"
                :value="getAttribute('first_name')"
                @input="addAttribute('first_name', $event)"
                id="first-name"
                type="text"></b-form-input>
        </b-form-group>

        <b-form-group
            v-if="isAttributeVisible('last_name')"
            description="Let us know your last name."
            id="last-name-group"
            label="Enter your last name"
            label-cols-lg="3"
            label-cols-sm="4"
            label-for="last-name"
        >
            <b-form-input
                :disabled="!isAttributeEditable('last_name')"
                :required="isAttributeRequired('last_name')"
                :value="getAttribute('last_name')"
                @input="addAttribute('last_name', $event)"
                id="last-name"
                type="text"></b-form-input>
        </b-form-group>

        <b-form-group
            v-if="isAttributeVisible('preferred_name')"
            description="What should we call you?"
            id="preferred-name-group"
            label="Enter your preferred name"
            label-cols-lg="3"
            label-cols-sm="4"
            label-for="preferred-name"
        >
            <b-form-input
                :disabled="!isAttributeEditable('preferred_name')"
                :required="isAttributeRequired('preferred_name')"
                :value="getAttribute('preferred_name')"
                @input="addAttribute('preferred_name', $event)"
                id="preferred-name"
                type="text"></b-form-input>
        </b-form-group>

        <b-form-group
            v-if="isAttributeVisible('email')"
            description="Let us know your email."
            id="email-group"
            label="Enter your email"
            label-cols-lg="3"
            label-cols-sm="4"
            label-for="email"
        >
            <b-form-input
                :disabled="!isAttributeEditable('email')"
                :required="isAttributeRequired('email')"
                :value="getAttribute('email')"
                @input="addAttribute('email', $event)"
                id="email"
                type="email"></b-form-input>
        </b-form-group>

        <b-form-group
            v-if="isAttributeVisible('dob')"
            description="Let us know your date of birth."
            id="dob-group"
            label="Enter your date of birth"
            label-cols-lg="3"
            label-cols-sm="4"
            label-for="dob"
        >
            <date-of-birth
                :disabled="!isAttributeEditable('dob')"
                :required="isAttributeRequired('dob')"
                :value="getAttribute('dob')"
                @input="addAttribute('dob', $event)"></date-of-birth>
        </b-form-group>

        <b-form-group
            v-if="isAttributeVisible(attribute.key)"
            :id="'additional-attribute-' + attribute.key"
            :key="attribute.key"
            :label="attribute.name"
            :label-for="'additional-attribute-' + attribute.key"
            description=""
            label-cols-lg="3"
            label-cols-sm="4"
            v-for="attribute in additionalAttributes"
        >
            <b-form-input :disabled="!isAttributeEditable(attribute.key)"
                          :required="isAttributeRequired(attribute.key)"
                          :id="'additional-attribute-' + attribute.key"
                          :value="getAttribute(attribute.key)"
                          @input="addAttribute(attribute.key, $event)"
                          type="text"></b-form-input>
        </b-form-group>


    </div>
</template>

<script>
    import DateOfBirth from './DateOfBirth';

    export default {
        name: "RegistrationQuestions",
        components: {DateOfBirth},
        props: {
            dataUser: {
                required: true,
                type: Object
            },
            attributes: {
                required: false,
                type: Object,
                default: function () {
                    return {};
                }
            }
        },

        created() {
            this.$api.settings().get(window.settingKeys.additional_attributes.user)
                .then(response => this.additionalAttributes = (response.data.value === null ? [] : response.data.value))
                .catch(error => this.$notify.alert('Could not load user information'));
        },

        data() {
            return {
                form: {},
                additionalAttributes: []
            }
        },

        methods: {
            addAttribute(key, value) {
                this.$set(this.form, key, value);
                this.$emit('input', this.form);
            },

            getAttribute(key) {
                if (this.form.hasOwnProperty(key)) {
                    return this.form[key];
                }
                return (this.dataUser.hasOwnProperty(key) ?
                    this.dataUser[key] : null);
            },
            isAttributeVisible(key) {
                for (const attributeKey of Object.keys(this.attributes)) {
                    if(key === attributeKey) {
                        return this.attributes[key].visible;
                    }
                }
            },
            isAttributeEditable(key) {
                for (const attributeKey of Object.keys(this.attributes)) {
                    if(key === attributeKey) {
                        return this.attributes[key].editable;
                    }
                }
            },
            isAttributeRequired(key) {
                for (const attributeKey of Object.keys(this.attributes)) {
                    if(key === attributeKey) {
                        return this.attributes[key].required;
                    }
                }
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
