<template>
    <div>
        <p-api-form
            :schema="module.settings"
            button-text="Update"
            :busy="$isLoading('updating-settings')"
            busy-text="Saving settings"
            @submit="updateSettings"
            :initial-data="initialData"
        ></p-api-form>
    </div>
</template>

<script>
    export default {
        name: "Settings",
        props: {
            module: {
                required: true,
                type: Object
            },
            moduleInstance: {
                required: true,
                type: Object
            },
        },

        computed: {
            initialData() {
                let data = {};
                this.moduleInstance.module_instance_settings.forEach(s => data[s.key] = s.value);
                return data;
            }
        },

        methods: {
            updateSettings(data) {
                data.module_instance_id = this.moduleInstance.id;
                this.$httpBasic.post('/module-instance-setting/many', data, {name: 'updating-settings'})
                    .then(response => this.$notify.success('Updated settings'))
                    .catch(error => this.$notify.alert('Something went wrong getting settings information: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
