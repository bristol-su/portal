<template>
    <div>
        <div v-if="editing">
<!--            <b-input type="text" size="sm" width="80%" v-model="newSettings">{{action.settings}}</b-input>-->
            <span><b-button variant="secondary" @click="updateSettings">Save Settings</b-button></span>
        </div>
        <div v-else>
            <span>{{action.settings}}</span>
            <span><b-button variant="secondary" @click="edit">Edit</b-button></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ActionSettings",

        props: {
            action: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                settings: null
            }
        },

        created() {
            this.settings = action.settings;
        },

        methods: {
            updateSettings() {
                this.$api.actionInstance().update(this.action.id, {
                    settings: this.newSettings
                })
                    .then(response => {
                        this.$notify.success('Updated settings');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update the settings: ' + error.message));
                this.editing = false;
            },
            edit() {
                this.newSettings = this.action.settings;
                this.editing = true;
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
