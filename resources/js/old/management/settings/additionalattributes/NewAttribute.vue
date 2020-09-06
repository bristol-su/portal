<template>
    <div>
        <b-form @submit.prevent="createAttribute">
            <b-form-group id="type-group" label="Type" description="What the additional attribute is for" label-for="type">
                <b-form-select
                    id="type"
                    v-model="form.type"
                    :options="typeOptions"
                    required
                ></b-form-select>
            </b-form-group>

            <b-form-group
                id="attribute-key-group"
                label="Attribute Key"
                label-for="attribute-key"
                description="What is the key of the attribute? You should include no spaces."
            >
                <b-form-input
                    id="attribute-key"
                    v-model="form.key"
                    type="text"
                    required
                    placeholder="e.g. student_id"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="attribute-name-group"
                label="Attribute Name"
                label-for="attribute"
                description="What is the name of the attribute?"
            >
                <b-form-input
                    id="attribute"
                    v-model="form.name"
                    type="text"
                    required
                    placeholder="e.g. Student ID"
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
    </div>
</template>

<script>
    export default {
        name: "NewAttribute",

        props: {
            type: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                form: {
                    type: null,
                    key: null,
                    name: null
                }
            }
        },

        mounted() {
            this.form.type = this.type;
        },

        methods: {
            createAttribute() {
                this.$emit('createAttribute', this.form);
            }
        },

        computed: {
            typeOptions() {
                return [
                    {text: 'User', value: 'user'},
                    {text: 'Group', value: 'group'},
                    {text: 'Role', value: 'role'},
                    {text: 'Position', value: 'position'},
                ]
            }
        }
    }
</script>

<style scoped>

</style>
