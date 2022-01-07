<template>
    <div>
        <p-dynamic-form
            :schema="formSchema"
            v-model="formData"
        >
            <template v-slot:append>
                <p-button @click.prevent="$emit('submit', formData)" :busy="busy" :busy-text="oldActivity ? 'Updating Activity' : 'Creating Activity'" :disabled="!submitEnabled">
                    {{ oldActivity ? 'Update' : 'Create' }}
                </p-button>
            </template>
        </p-dynamic-form>
    </div>
</template>

<script>
import Field from '@bristol-su/portal-ui-kit/src/generator/schema/Field';

export default {
    name: "ActivityForm",
    props: {
        busy: {
            required: false,
            type: Boolean,
            default: false
        },
        oldActivity: {
            required: false,
            type: Object
        }
    },
    mounted() {
        if(this.oldActivity) {
            this.formData = {
                name: this.oldActivity.name,
                description: this.oldActivity.description,
                slug: this.oldActivity.slug,
                activity_for: this.oldActivity.activity_for,
                admin_logic: this.oldActivity.admin_logic,
                for_logic: this.oldActivity.for_logic,
                range: {
                    lower: this.oldActivity.start_date,
                    upper: this.oldActivity.end_date
                },
                type: this.oldActivity.type,
                active: this.oldActivity.enabled
            }
        }
    },
    data() {
        return {
            formData: {}
        }
    },
    watch: {
        formData: {
            handler(newFormData, oldFormData) {
                if(newFormData.name && oldFormData.name !== newFormData.name && newFormData.slug === oldFormData.slug) {
                    this.formData.slug = this.slugify(newFormData.name);
                }
            },
            deep: true
        }
    },
    methods: {
        slugify(string) {
            const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;'
            const b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------'
            const p = new RegExp(a.split('').join('|'), 'g')

            return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '') // Trim - from end of text
        }
    },
    computed: {
        /* Return false if the form is edit and has not been updated. */
        submitEnabled() {
            if(this.oldActivity) {
                return (
                    this.oldActivity.name !== this.formData.name
                    || this.oldActivity.description !== this.formData.description
                    || this.oldActivity.slug !== this.formData.slug
                    || this.oldActivity.activity_for !== this.formData.activity_for
                    || this.oldActivity.admin_logic !== this.formData.admin_logic
                    || this.oldActivity.for_logic !== this.formData.for_logic
                    || this.oldActivity.start_date !== this.formData.range.lower
                    || this.oldActivity.end_date !== this.formData.range.upper
                    || this.oldActivity.type !== this.formData.type
                    || this.oldActivity.active !== this.formData.active
                )
            }
            return true;
        },
        currentActivityUrl() {
            return this.$tools.routes.basic.baseWebUrl() + '/' + (this.formData.slug ?? '...')
        },
        formSchema() {
            let form = this.$tools.generator.form.newForm()
                    .withGroup(
                        this.$tools.generator.group.newGroup('Basic Information')
                            .withField(
                                this.$tools.generator.field.text('name')
                                    .label('Activity Name')
                                    .hint('A name for the activity.')
                                    .tooltip('This should be a short name that quickly lets the user know what the activity does.')
                                    .required(true)
                            )
                            .withField(
                                this.$tools.generator.field.text('description')
                                    .label('Description')
                                    .hint('A description for the activity. This is shown to users.')
                                    .tooltip('A user can see this description as part of the activity, so it should help them identify the activity.')
                                    .required(true)
                            )
                            .withField(
                                this.$tools.generator.field.text('slug')
                                    .label('Slug')
                                    .hint('The URL which the activity will be located at (' + this.currentActivityUrl + ').')
                                    .tooltip('This is usually set for you. Make sure to include no spaces.')
                                    .required(true)
                            )
                    )
                    .withGroup(
                        this.$tools.generator.group.newGroup('Audience')
                            .withField(
                                this.$tools.generator.field.logic('for_logic')
                                    .label('Select the audience')
                                    .hint('This is the group of students who can access the activity.')
                                    .required(true)
                            )
                            .withField(
                                this.$tools.generator.field.logic('admin_logic')
                                    .label('Select the administrators of the activity')
                                    .hint('This is the group of users who should admin the activity.')
                                    .required(true)
                            )
                    );
            if(!this.oldActivity) {
                form.withGroup(

                    this.$tools.generator.group.newGroup('Setup Information')
                        .withField(
                            this.$tools.generator.field.radios('activity_for')
                                .label('Who works together for this activity?')
                                .hint('E.g. Group means anyone in the same group will share the uploaded data from anyone else in the group.')
                                .required(true)
                                .withOption('user', 'Users')
                                .withOption('group', 'Groups')
                                .withOption('role', 'Roles')
                        )
                        .withField(
                            this.$tools.generator.field.radios('type')
                                .label('Activity Completion')
                                .hint('Select how many times the activity can be completed.')
                                .required(true)
                                .withOption('completable', 'Once')
                                .withOption('multi-completable', 'Multiple Times')
                                .withOption('open', 'Never')
                        )
                )
            }
            form.withGroup(
                this.$tools.generator.group.newGroup('Active Range')
                    .withField(
                        new Field('daterange', 'range')
                            .label('When should this activity be available')
                            .hint('The activity will be shown after the start date, and hidden after the end date. If you give no dates, it will always be shown.')
                            .required(false)
                    )
            )
            if(this.oldActivity) {
                form.withField(
                    this.$tools.generator.field.switch('active')
                        .label('Published')
                        .hint('Whether the activity has been published')
                        .required(false)
                )
            }
            return form.generate().asJson();
        }
    }
}
</script>

<style scoped>

</style>
