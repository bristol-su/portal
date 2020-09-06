<template>
    <div>
        <b-form-group
            label-cols-sm="3"
            label="Footer"
            description="Footer to show at the bottom of the page. You should use HTML tags."
            label-align-sm="right"
            label-for="footer"
        >
            <b-form-textarea
                id="footer"
                :value="value"
                @input="updateAttribute"
                placeholder="Portal Footer"
                rows="3"
            ></b-form-textarea>
        </b-form-group>


    </div>
</template>

<script>
    export default {
        name: "FooterTest",

        props: {},

        data() {
            return {
                value: ''
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.pageText.footer, '')
                .then(response => this.value = response.data.value)
                .catch(error => this.$notify.alert('Could not load footer text'));
        },

        methods: {
            updateAttribute: _.debounce(function(message) {
                this.$emit('input', message);
                if(message !== this.value) {
                    this.value = message;
                    this.$api.settings().set(window.settingKeys.pageText.footer, message)
                        .then(response => this.$notify.success('Updated the message.'))
                        .catch(error => this.$notify.alert('Could not update the footer text.'));
                }
            }, 900)
        },

    }
</script>

<style scoped>

</style>
