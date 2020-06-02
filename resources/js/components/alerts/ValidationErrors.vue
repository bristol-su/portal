<template>
    <div>
        <validation-alert v-for="(message, key) in errorInformation" :key="key" :label="key" :message="message"></validation-alert>
    </div>
</template>

<script>
    import ValidationAlert from './ValidationAlert';
    export default {
        name: "ValidationErrors",
        components: {ValidationAlert},
        props: {},

        data() {
            return {
                errors: {}
            }
        },

        mounted() {
            window.vueEvents.$on('validationErrorsSet', this.setErrors);
        },

        methods: {
            setErrors(errors) {
                this.errors = errors;
            }
        },

        computed: {
            errorInformation() {
                if(this.errors.hasOwnProperty('errors')) {
                    return this.errors.errors;
                }
                return {};
            }
        }
    }
</script>

<style scoped>

</style>
