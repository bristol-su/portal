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


                <vue-form-generator :schema="filter.options.schema" :model="settings" :options="filter.options.options">

                </vue-form-generator>



                <b-button variant="primary" @click="addFilter">Submit</b-button>
            </b-form>
        </div>
    </div>
</template>

<script>

    import VueFormGenerator from 'vue-form-generator';

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

        created() {
            this.settings = VueFormGenerator.schema.createDefaultObject(this.filter.options.schema);
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
