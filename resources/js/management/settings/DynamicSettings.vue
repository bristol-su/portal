<template>
    <div>
        <b-button variant="success" @click="save">Save Changes</b-button>

        <p-dynamic-form :schema="schema" v-model="model"></p-dynamic-form>
    </div>
</template>

<script>
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
