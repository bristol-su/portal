<template>
    <div>
        <p-dynamic-form
            :schema="formSchema"
            v-model="formData"
        >
            <template v-slot:append>
                <p-button @click.prevent="$emit('submit', formData)" :busy="busy" :busy-text="oldModule ? 'Updating Module' : 'Creating Module'" :disabled="!submitEnabled">
                    {{ oldModule ? 'Update' : 'Create' }}
                </p-button>
            </template>
        </p-dynamic-form>
    </div>
</template>

<script>

export default {
    name: "ModuleForm",
    props: {
        busy: {
            required: false,
            type: Boolean,
            default: false
        },
        oldModule: {
            required: false,
            type: Object
        },
        module: {
            required: true,
            type: Object
        },
        activity: {
            required: true,
            type: Object
        }
    },
    mounted() {
        this.formData.active = this.activity.for_logic;
        this.formData.visible = this.activity.for_logic;
        this.formData.mandatory = this.isCompletable ? this.activity.for_logic : null;


        if(this.oldModule) {
            this.formData = {
                name: this.oldModule.name,
                description: this.oldModule.description,
                slug: this.oldModule.slug,
                active: this.oldModule.active,
                visible: this.oldModule.visible,
                mandatory: this.oldModule.mandatory,
                completion_condition_alias: this.oldModule.completion_condition_instance?.alias,
                completion_condition_settings: this.oldModule.completion_condition_instance?.settings
            }
        }
    },
    data() {
        return {
            formData: {
                name: null,
                description: null,
                slug: null,
                active: null,
                visible: null,
                mandatory: null,
                completion_condition_alias: null,
                completion_condition_settings: null,
            }
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
            if(this.oldModule) {
                return (
                    this.oldModule.name !== this.formData.name
                    || this.oldModule.description !== this.formData.description
                    || this.oldModule.slug !== this.formData.slug
                    || this.oldModule.active !== this.formData.active
                    || this.oldModule.visible !== this.formData.visible
                    || this.oldModule.mandatory !== this.formData.mandatory
                    || this.oldModule.completion_condition_instance?.alias !== this.formData.completion_condition_alias
                    || this.oldModule.completion_condition_instance?.settings !== this.formData.completion_condition_settings
                )
            }
            return true;
        },
        currentModuleUrl() {
            return this.$tools.routes.basic.baseWebUrl() + '/' + this.activity.slug + '/' + (this.formData.slug ?? '...')
        },
        formSchema() {
            let form = this.$tools.generator.form.newForm()
                .withGroup(
                    this.$tools.generator.group.newGroup('Basic Information')
                        .withField(
                            this.$tools.generator.field.text('name')
                                .label('Module Name')
                                .hint('A name for the module.')
                                .tooltip('This should be a short name that quickly lets the user know what the module does.')
                                .required(true)
                        )
                        .withField(
                            this.$tools.generator.field.text('description')
                                .label('Description')
                                .hint('A description for the module. This is shown to users.')
                                .tooltip('A user can see this description as part of the module, so it should help them identify the module.')
                                .required(true)
                        )
                        .withField(
                            this.$tools.generator.field.text('slug')
                                .label('Slug')
                                .hint('The URL which the module will be located at (' + this.currentModuleUrl + ').')
                                .tooltip('This is usually set for you. Make sure to include no spaces.')
                                .required(true)
                        )
                )

            let behaviourGroup = this.$tools.generator.group.newGroup('Behaviour')
                .withField(
                    this.$tools.generator.field.logic('active')
                        .label('Who can access the module?')
                        .hint('This is the group of students who can access this module.')
                        .required(true)
                )
                .withField(
                    this.$tools.generator.field.logic('visible')
                        .label('Who can see the module?')
                        .hint('This is the group of students who can see the module on the main page.')
                        .required(true)
                )

            if(this.isCompletable) {
                behaviourGroup.withField(
                    this.$tools.generator.field.logic('mandatory')
                        .label('Who must complete the module?')
                        .hint('This is the group of students who must complete the module.')
                        .required(true)
                )
                .withField(
                    this.$tools.generator.field.select('completion_condition_alias')
                        .label('Completion')
                        .hint('What condition must be met to mark the module as complete?')
                        .setOptions(this.module.completionConditions.map(c => {
                            return {id: c.alias, value: c.name}
                        }))
                        .nullLabel('-- Please select an option --', null)
                        .required(true)
                )
                if(this.formData.completion_condition_alias) {
                    behaviourGroup.withField(
                        this.$tools.generator.field.subform('completion_condition_settings')
                            .form(this.module.completionConditions.find(c => c.alias === this.formData.completion_condition_alias).options)
                    )
                }
            }

            form.withGroup(behaviourGroup);

            return form.generate().asJson();
        },
        isCompletable() {
            return this.activity.type === 'completable' || this.activity.type === 'multi-completable'
        }
    }
}
</script>

<style scoped>

</style>
