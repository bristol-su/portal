<template>
    <b-list-group-item class="flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{attributeKey}}</h5>
        </div>

        <p class="mb-1 text-left">
            <b-form-checkbox-group
                size="sm"
                @change="updateAttributes"
                :checked="getAttributes"
                :options="attributeOptions"
                stacked
            ></b-form-checkbox-group>
        </p>

    </b-list-group-item>
</template>

<script>
    export default {
        name: "RegistrationAttribute",

        props: {
            value: {
                required: true,
                type: Object
            },
            attributeKey: {
                required: true,
                type: String
            },
        },

        methods: {
            updateAttributes(attributes) {
                this.$emit('input', {
                    visible: attributes.indexOf('visible') !== -1,
                    editable: attributes.indexOf('editable') !== -1,
                    required: attributes.indexOf('required') !== -1
                })
            }
        },

        computed: {
            attributeOptions() {
                return [
                    {text: 'Visible', value: 'visible'},
                    {text: 'Editable', value: 'editable'},
                    {text: 'Required', value: 'required'},
                ]
            },
            getAttributes() {
                return Object.keys(this.value).filter(attributeKey => this.value[attributeKey] === true)
            }
        }
    }
</script>

<style scoped>

</style>
