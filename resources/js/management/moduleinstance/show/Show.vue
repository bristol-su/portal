<template>
    <div style="text-align: left;">

        <p-tabs>
            <p-tab title="Module Info">
                <module-form :old-module="moduleInstance" :module="module" :activity="activity" @submit="updateModule" :busy="$isLoading('updating-module')">

                </module-form>
            </p-tab>

            <p-tab title="Settings">
                <settings :module="module" :module-instance="moduleInstance"></settings>
            </p-tab>

            <p-tab title="Permissions">
                <permissions :module-instance="moduleInstance" :module="module"></permissions>
            </p-tab>

            <p-tab title="Services" v-if="module.services.optional.length > 0 || module.services.required.length > 0">
                <services :module-instance="moduleInstance" :module="module"></services>
            </p-tab>

            <p-tab title="Actions">
                <actions :module-instance="moduleInstance" :module="module"></actions>
            </p-tab>
        </p-tabs>

    </div>
</template>

<script>
    import ModuleForm from '../ModuleForm';
    import Settings from './Settings';
    import Permissions from './Permissions';
    import Services from './Services';
    import Actions from './Actions';

    export default {
        name: "Show",
        components: {Actions, Services, Permissions, Settings, ModuleForm},
        props: {
            moduleInstance: {
                required: true,
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
        methods: {
            updateModule(data) {
                data.activity_id = this.activity.id;
                data.alias = this.moduleInstance.alias;
                this.$api.moduleInstances().update(this.moduleInstance.id, data)
                    .then(response => {
                        this.$notify.success('Module ' + this.moduleInstance.name + ' updated!');
                    })
                    .catch(error => this.$notify.alert('Something went wrong: ' + error.message));
            },
        }
    }
</script>

<style scoped>
    .view-header {
        font-size: 25px;
    }

    .show-card {
        margin-top: 10px;
        margin-bottom: 5px;
    }
</style>
