<template>
    <div>
        <b-button variant="success" @click="save">Save Changes</b-button>

        <vue-form-generator :schema="schema.schema" :model="model" :options="schema.options">
        </vue-form-generator>
    </div>
</template>

<script>
import VueFormGenerator from 'vue-form-generator';

export default {
    name: "DynamicSettings",
    props: {
        schema: {
            required: true,
            type: Object
        },
        settingKeys: {
            required: false,
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            model: {}
        }
    },
    created() {
        let defaultModel = VueFormGenerator.schema.createDefaultObject(this.schema.schema);
        this.schema.schema.groups.forEach(group => {
            Object.assign(defaultModel, VueFormGenerator.schema.createDefaultObject(group))
        })
        this.model = defaultModel;
    },
    methods: {
        save() {
            let promises = Object.keys(this.model).map((inputName) => {
                return this.$api.settings().set(
                    this.settingKeys[inputName],
                    this.model[inputName]
                );
            })
            Promise.all(promises)
                .then(values => this.$notify.success('Settings saved'))
                .catch(error => console.log(error));
        }
    }
}
</script>

<style scoped>

</style>
