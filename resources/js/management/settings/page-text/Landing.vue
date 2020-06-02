<template>
    <div>
        <b-form-group
            label-cols-sm="3"
            label="Landing Page"
            description="Text to show on the landing page."
            label-align-sm="right"
            label-for="landing"
        >
            <b-form-textarea
                id="landing"
                :value="value"
                @input="updateAttribute"
                placeholder="Welcome to the portal!"
                rows="3"
            ></b-form-textarea>
        </b-form-group>
    </div>
</template>

<script>
    export default {
        name: "Landing",

        props: {},

        data() {
            return {
                value: ''
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.pageText.landing, '')
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load landing text'));
        },

        methods: {
            updateAttribute: _.debounce(function(message) {
                this.$emit('input', message);
                if(message !== this.value) {
                    this.value = message;
                    this.$api.settings().set(window.settingKeys.pageText.landing, message)
                        .then(response => this.$notify.success('Updated the message.'))
                        .catch(error => this.$notify.alert('Could not update the landing text.'));
                }
            }, 900)
        },

    }
</script>

<style scoped>

</style>
