<template>
    <div style="text-align: left;">

        <b-form-group
            description="A name for the logic"
            id="name-group"
            label="Name:"
            label-for="name"
        >
            <b-form-input
                id="name"
                required
                type="text"
                v-model="form.name"
            ></b-form-input>
        </b-form-group>


        <b-form-group
            description="A description for the activity"
            id="description-group"
            label="Description:"
            label-for="description"
        >
            <b-form-input
                id="description"
                required
                type="text"
                v-model="form.description"
            ></b-form-input>
        </b-form-group>

        <b-button @click="create" v-if="logic === null" variant="secondary">Create Logic</b-button>

        <b-form-group label="Filters" v-if="logic !== null">
            <filter-group @input="addFilter($event, 'all_true')" title="All True">

            </filter-group>

            <filter-group @input="addFilter($event, 'all_false')" title="All False">

            </filter-group>

            <filter-group @input="addFilter($event, 'any_true')" title="Any Must Be True">

            </filter-group>

            <filter-group @input="addFilter($event, 'any_false')" title="Any Must Be False">

            </filter-group>
        </b-form-group>

        <a :href="'/logic/' + logic.id" v-if="logic !== null">
            <b-button variant="secondary">Finish</b-button>
        </a>
    </div>
</template>

<script>
    import FilterGroup from "./filter/FilterGroup";

    export default {
        name: "Create",
        components: {FilterGroup},
        data() {
            return {
                form: {
                    name: '',
                    description: ''
                },
                logic: null
            }
        },

        methods: {
            create() {
                this.$api.logic().create(this.form)
                    .then(response => {
                        this.$notify.success('Logic ' + this.form.name + ' created!');
                        this.logic = response.data;
                        // window.setTimeout(() => {window.location.href = '/logic/' + response.data.id}, 3000);
                    })
                    .catch(error => this.$notify.alert('Logic could not be created: ' + error.message))
            },
            addFilter(filterId, type) {
                this.$api.logic().attachFilter(this.logic.id, filterId, type)
                    .then(response => this.$notify.success('Filter attached to logic'))
                    .catch(error => this.$notify.alert('Could not attach filter to logic: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
