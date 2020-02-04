<template>
    <div>
        <b-form-input
            type="text"
            placeholder="e.g. You are not registered on our systems"
            :value="currentMessage"
            @input="updateAttribute"
        ></b-form-input>
    </div>
</template>

<script>
    export default {
        name: "NotInData",

        data() {
            return {
                currentMessage: null,
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.authentication.messages.notInData, null)
                .then(response => this.currentMessage = response.data.value)
                .catch(error => this.$notify.alert('Could not load current message'));
        },

        methods: {
            updateAttribute: _.debounce(function(message) {
                this.$emit('input', message);
                if(message !== this.currentMessage) {
                    this.currentMessage = message;
                    this.$api.settings().set(window.settingKeys.authentication.messages.notInData, message)
                        .then(response => this.$notify.success('Updated the message.'))
                        .catch(error => this.$notify.alert('Could not update the message.'));
                }
            }, 900)
        }
    }
</script>

<style scoped>

</style>
