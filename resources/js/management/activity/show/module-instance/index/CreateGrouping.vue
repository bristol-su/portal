<template>
    <div>
        <p-dynamic-form
            :schema="formSchema"
            v-model="formData"
        >
            <template v-slot:append>
                <p-button @click.prevent="saveGrouping" :busy="loading" :busy-text="oldGroupingId ? 'Update Section' : 'Create Section'" :disabled="loading">
                    {{ oldGroupingId ? 'Update' : 'Create' }}
                </p-button>
            </template>
        </p-dynamic-form>
    </div>
</template>

<script>

export default {
    name: "CreateGrouping",
    props: {
        oldGroupingId: {
            required: false,
            type: Number
        },
        oldGroupingHeader: {
            required: false,
            type: String
        },
        activityId: {
            required: true,
            type: Number
        }
    },
    mounted() {
        if(this.oldGroupingId) {
            this.formData.heading = this.oldGroupingHeader;
        }
    },
    data() {
        return {
            formData: {},
            loading: false
        }
    },
    methods: {
        saveGrouping() {
            this.loading = true;
            if(this.oldGroupingId) {
                this.$api.modules().updateGrouping(this.oldGroupingId, this.formData.heading)
                    .then(response => {
                        this.$emit('updated', response.data);
                        this.$emit('close');
                    })
                    .catch(error => this.$notify.alert('Could not update section: ' + error.message))
                    .then(() => this.loading = false);
            } else {
                this.$api.modules().addGrouping(this.formData.heading, this.activityId)
                    .then(response => {
                        this.$emit('created', response.data);
                        this.$emit('close');
                    })
                    .catch(error => this.$notify.alert('Could not create section: ' + error.message))
                    .then(() => this.loading = false);
            }
        }
    },
    computed: {
        formSchema() {
            return this.$tools.generator.form.newForm()
                .withField(
                    this.$tools.generator.field.text('heading')
                        .label('Section name')
                        .hint('A label for the section.')
                        .tooltip('This will help you to group similar modules together to make it easier for students to navigate.')
                        .required(true)
                )
                .generate().asJson();
        }
    }
}
</script>

<style scoped>

</style>
