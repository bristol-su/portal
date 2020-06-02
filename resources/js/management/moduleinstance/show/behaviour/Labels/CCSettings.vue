<template>
    <div>
        <div v-if="editSettings">
            <div v-if="rawCompletionCondition !== null">
                <vue-form-generator :schema="rawCompletionCondition.options.schema" :model="settings" :options="rawCompletionCondition.options.options">

                </vue-form-generator>

                <b-button variant="secondary" @click="saveSettings">Save</b-button>
            </div>
        </div>
        <div v-else>
            <data-item v-for="(val, setting) in settings" :key="setting" :title="setting">
                {{val}}
            </data-item>
            <b-button variant="secondary" @click="editSettings = true">Edit</b-button>
        </div>
    </div>
</template>

<script>
    import VueFormGenerator from 'vue-form-generator';
    import DataItem from '../../../../../utilities/DataItem';

    export default {
        name: "CCSettings",

        components: {DataItem},
        props: {
            completionCondition: {
                required: true,
                type: Object
            },
            moduleAlias: {
                required: true,
                type: String
            }
        },

        data() {
            return {
                editSettings: false,
                settings: {},
                rawCompletionCondition: null
            }
        },

        created() {
            this.loadCompletionCondition();
        },

        methods: {
            saveSettings() {
                this.$api.completionConditionInstances().update(this.completionCondition.id, {
                    settings: this.settings
                })
                    .then(response => {
                        this.$notify.success('Updated settings');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update settings: ' + error.message));
            },
            loadCompletionCondition() {
                this.$api.completionConditions().getByAlias(this.moduleAlias, this.completionCondition.alias)
                    .then(response => {
                        this.rawCompletionCondition = response.data;
                        this.settings = VueFormGenerator.schema.createDefaultObject(this.rawCompletionCondition.options.schema, this.completionCondition.settings);
                    })
                    .catch(error => this.$notify.alert('Could not load completion condition: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
