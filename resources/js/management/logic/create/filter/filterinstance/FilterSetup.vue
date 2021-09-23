<template>
    <div>
        <div>
            <b-form>
                <b-form-group
                    id="name-group"
                    label="Name:"
                    label-for="name"
                    description="Name of the filter"
                >
                    <b-form-input
                        id="name"
                        v-model="name"
                        type="text"
                        required
                        :placeholder="filter.name"
                    ></b-form-input>
                </b-form-group>

                <p-dynamic-form :schema="filter.options" v-model="settings"></p-dynamic-form>

                <b-button variant="primary" @click="addFilter">Submit</b-button>
            </b-form>
        </div>
    </div>
</template>

<script>

    export default {
        name: "FilterSetup",

        props: {
            filter: {
                required: true,
                type: Object
            },
        },

        data() {
            return {
                name: '',
                settings: {}
            }
        },

        methods: {
            addFilter() {
                this.$api.filterInstance().create({
                    alias: this.filter.alias,
                    name: this.name,
                    settings: this.settings,
                })
                    .then(response => this.$emit('input', response.data))
                    .catch(error => this.$notify.alert('Could not create filter: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
