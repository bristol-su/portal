<template>
    <div style="text-align: left;">
        <div v-if="loading">Loading...</div>
        <div v-else>
            <vue-form-generator :schema="settingsSchema.schema" :model="model" :options="settingsSchema.options">
            </vue-form-generator>
        </div>
        <b-button @click="saveSettings">Save Settings</b-button>

    </div>
</template>

<script>
    import moduleInstanceSettings from '../../../../utilities/api/resources/moduleInstanceSettings';
    import VueFormGenerator from 'vue-form-generator';
    import axios from 'axios';

    export default {
        name: "Settings",

        props: {
            moduleInstance: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                settingsSchema: {},
                moduleInstanceSettings: [],
                model: {},
                schemaLoading: true,
                settingsLoading: true
            }
        },

        created() {
            this.loadSettingsSchema();
        },

        methods: {
            loadSettingsSchema() {
                this.schemaLoading = true;
                this.$api.modules().getByAlias(this.moduleInstance.alias)
                    .then(response => {
                        this.settingsSchema = response.data.settings;
                        this.loadSettings();
                    })
                    .catch(error => this.$notify.alert('Could not load available settings: ' + error.message))
                    .then(() => this.schemaLoading = false);
            },
            loadSettings() {
                this.settingsLoading = true;
                this.$api.moduleInstanceSettings().forModuleInstance(this.moduleInstance.id)
                    .then(response => {
                        this.moduleInstanceSettings = response.data;
                        let model = {}
                        this.moduleInstanceSettings.forEach(setting => {
                            if(_.isObject(setting.value) || _.isArray(setting.value)) {
                                this.$set(model, setting.key, JSON.parse(JSON.stringify(setting.value)))
                            } else {
                                this.$set(model, setting.key, setting.value)
                            }
                        });
                        this.model = VueFormGenerator.schema.createDefaultObject(this.settingsSchema.schema, model);
                    })
                    .catch(error => this.$notify.alert('Could not load settings: ' + error.message))
                    .then(() => this.settingsLoading = false);
            },

            saveSettings() {

                axios.all(Object.keys(this.model).filter(key => {
                    let settings = this.settings.filter(setting => setting.key === key);
                    if(settings.length > 0) {
                        return this.model[key] !== settings[0].value;
                    }
                    return true;
                }).map(key => {
                    let settings = this.moduleInstanceSettings.filter(setting => setting.key === key);
                    if(settings.length > 0) {
                        return this.$api.moduleInstanceSettings().update(settings[0].id, this.model[key])
                    }
                    return this.$api.moduleInstanceSettings().create(key, this.model[key], this.moduleInstance.id);
                }))
                    .then(responses => this.loadSettings())
                    .catch(error => this.$notify.alert('There was a problem saving some settings'));

            },

        },

        computed: {
            loading() {
                return this.schemaLoading || this.settingsLoading;
            }
        }
    }
</script>

<style scoped>

</style>
