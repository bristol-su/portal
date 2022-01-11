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
            </p-tab>

            <p-tab title="Services">
            </p-tab>
        </p-tabs>


<!--        <div>-->
<!--            <b-card no-body>-->
<!--                <b-tabs card pills vertical>-->
<!--                    <b-tab active title="Module Information">-->
<!--                        <module-instance-->
<!--                            :module-instance="moduleInstance">-->

<!--                        </module-instance>-->
<!--                    </b-tab>-->
<!--                    <b-tab title="Behaviour">-->
<!--                        <behaviour-->
<!--                            :module-instance="moduleInstance">-->
<!--                        </behaviour>-->
<!--                    </b-tab>-->
<!--                    <b-tab title="Settings">-->
<!--                        <settings :module-instance="moduleInstance"></settings>-->
<!--                    </b-tab>-->
<!--                    <b-tab title="Permissions">-->
<!--                        <permissions :module-instance="moduleInstance"></permissions>-->

<!--                    </b-tab>-->
<!--                    <b-tab title="Services">-->
<!--                        <services :module-instance="moduleInstance"></services>-->

<!--                    </b-tab>-->
<!--                    <b-tab title="Actions">-->
<!--                        <actions :module-instance="moduleInstance">-->

<!--                        </actions>-->
<!--                    </b-tab>-->
<!--                </b-tabs>-->
<!--            </b-card>-->
<!--        </div>-->


    </div>
</template>

<script>
    import ModuleForm from '../ModuleForm';
    import Settings from './settings/Settings';

    export default {
        name: "Show",
        components: {Settings, ModuleForm},
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
                this.$api.moduleInstances().update(this.moduleInstance.id, data)
                    .then(response => {
                        this.$notify.success('Module Instance ' + this.form.name + ' updated!');
                    })
                    .catch(error => this.$notify.alert('Something went wrong: ' + error.message));
            },
            updateModuleSettings(data) {
                console.log(data);
            }
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
