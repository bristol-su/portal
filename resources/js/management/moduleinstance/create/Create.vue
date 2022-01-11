<template>
    <div>

        <p-page-content
            v-if="!moduleType"
            title="Create a module"
            subtitle="Select a module type to create a module from"
        >
            <p-card-group title="Select a module type">
                <p-card
                    v-for="moduleId in moduleIds"
                    :key="moduleId"
                    :title="modules[moduleId].name"
                    :subtitle="modules[moduleId].description"
                    :url="generateModuleViewUrl(moduleId)"
                    url-text="Select"
                    :disabled="!isEnabled(moduleId)"
                ></p-card>
            </p-card-group>
        </p-page-content>

        <p-page-content
            v-else
            title="Create a module"
            subtitle="Fill in more information to create the module"
        >
            <module-form :activity="activity" :module="activeModule" @submit="createModuleInstance">

            </module-form>
        </p-page-content>

        <!---->
<!--            <tab-content title="Behaviour">-->
<!--                <behaviour-->
<!--                    :completion-conditions="selectedModule.completionConditions"-->
<!--                    :for-logic="forLogic"-->
<!--                    :activity="activity"-->
<!--                    @update="updateBehaviour"-->
<!--                    @createModuleInstance="createModuleInstance"-->
<!--                >-->
<!--                </behaviour>-->
<!--            </tab-content>-->
<!---->
<!---->
<!--            <tab-content title="Services" v-if="hasModuleInstance">-->
<!--                <services :module-instance="moduleInstance"></services>-->
<!--            </tab-content>-->
<!--            <tab-content title="Settings" v-if="hasModuleInstance">-->
<!--                <settings :module-instance="moduleInstance"></settings>-->
<!--            </tab-content>-->
<!--            <tab-content title="Permissions" v-if="hasModuleInstance">-->
<!--                <permissions :module-instance="moduleInstance"></permissions>-->
<!--            </tab-content>-->
<!---->
<!--        </form-wizard>-->
    </div>
</template>

<script>
    import ModuleForm from '../ModuleForm';

    export default {
        name: "Create",

        components: {
            ModuleForm,
        },

        props: {
            modules: {
                required: true,
                type: Object
            },
            moduleType: {
                required: false,
                type: String,
                default: null
            },
            forLogic: {
                required: true,
                type: String
            },
            activity: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                form: {
                    alias: '',
                    name: '',
                    description: '',
                    slug: '',
                    active: null,
                    visible: null,
                    mandatory: null,
                    completion_condition_instance_id: null
                },
                moduleInstance: null,
                selectedModule: {}
            }
        },

        methods: {
            isEnabled(moduleId) {
                let moduleFor = this.modules[moduleId].for;
                return moduleFor === 'user'
                    || (moduleFor === 'group' && (this.activity.activity_for === 'group' || this.activity.activity_for === 'role'))
                    || (moduleFor === 'role' && this.activity.activity_for === 'role');
            },

            updateBehaviour(type, value) {
                this.form[type] = value;
            },

            generateModuleViewUrl(moduleId) {
                return this.$tools.routes.basic.baseWebUrl() + '/activity/' + this.activity.id + '/module-instance/create?module_type=' + moduleId;
            },

            createModuleInstance(data) {
                data.activity_id = this.activity.id;
                data.alias = this.moduleType;
                this.$api.moduleInstances().create(data)
                    .then(response => {
                        this.$notify.success('Module Instance ' + this.form.name + ' created!');
                        this.moduleInstance = response.data;
                        window.location.href = this.$tools.routes.basic.baseWebUrl() + '/activity/' + this.activity.id + '/module-instance/' + this.moduleInstance.id;
                    })
                    .catch(error => this.$notify.alert('Something went wrong: ' + error.message));

            },

        },

        computed: {
            hasModuleInstance() {
                return this.moduleInstance !== null;
            },

            moduleIds() {
                return Object.keys(this.modules);
            },

            activeModule() {
                if(!this.moduleType){
                    return null;
                }
                return this.modules[this.moduleType];
            }
        }
    }
</script>

<style scoped>

</style>
