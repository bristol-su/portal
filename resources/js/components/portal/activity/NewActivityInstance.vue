<template>
    <div>
            <p-api-form :schema="form" v-model="formData" @submit="createNewActivityInstance">
                <template #buttonText>Create</template>
            </p-api-form>
    </div>
</template>

<script>
    import Url from 'domurl';

    export default {
        name: "NewActivityInstance",

        props: {
            activityId: {
                required: true,
                type: Number
            },
            resourceType: {
                required: true,
                type: String
            },
            resourceId: {
                required: true,
                type: Number
            }
        },

        data() {
            return {
                formData: {
                    name: '',
                    description: ''
                }
            }
        },

        methods: {
            createNewActivityInstance() {
                this.$api.activityInstance().create({
                    name: this.name,
                    description: this.description,
                    activity_id: this.activityId,
                    resource_type: this.resourceType,
                    resource_id: this.resourceId
                })
                    .then(response => {
                        let u = new Url;
                        u.query.a = response.data.id;
                        window.location = u.toString();
                    })
                    .catch(error => this.$notify.alert('Sorry, something went wrong: ' + error.message));
            }
        },

        computed: {
            form() {
                return this.$tools.generator.form.newForm('New Activity Instance')
                    .withGroup(this.$tools.generator.group.newGroup()
                        .withField(this.$tools.generator.field.text('name')
                            .label('Name')
                            .hint('A name to identify the run through')
                            .required(true)
                        )
                        .withField(this.$tools.generator.field.text('description')
                            .label('Description')
                            .hint('A description to identify the run through')
                            .required(true)
                        )
                    )
                    .generate()
                    .asJson()
            }
        }
    }
</script>

<style scoped>

</style>
