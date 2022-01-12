<template>
    <div>
        <div>
            <p-api-form
                :schema="permissionsSchema"
                button-text="Update"
                :busy="$isLoading('updating-permissions')"
                busy-text="Saving permissions"
                @submit="updatePermissions"
                :initial-data="initialData"
            ></p-api-form>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Permissions",
        props: {
            module: {
                required: true,
                type: Object
            },
            moduleInstance: {
                required: true,
                type: Object
            },
        },

        data() {
            return {
                loading: true
            }
        },

        methods: {
            updatePermissions(data) {
                this.$api.moduleInstancePermissions().updateMany(this.moduleInstance.id, data, 'updating-permissions')
                    .then(response => this.$notify.success('Permissions updated'))
                    .catch(error => this.$notify.alert('Could not update permissions: ' + error.message));
            }
        },

        computed: {
            initialData() {
                let initialData = {};
                this.moduleInstance.module_instance_permissions.forEach(permission => initialData[permission.ability] = permission.logic_id);
                return initialData;
            },
            permissionsSchema() {
                let participantGroup = this.$tools.generator.group.newGroup('Participant');
                let adminGroup = this.$tools.generator.group.newGroup('Admin');

                this.module.permissions.forEach(permission => {
                    if(permission.module_type === 'participant') {
                        participantGroup.withField(
                            this.$tools.generator.field.logic(permission.ability)
                                .label(permission.name)
                                .hint(permission.description)
                        )
                    } else {
                        adminGroup.withField(
                            this.$tools.generator.field.logic(permission.ability)
                                .label(permission.name)
                                .hint(permission.description)
                        )
                    }
                })
                return this.$tools.generator.form.newForm('Permissions')
                    .withGroup(participantGroup)
                    .withGroup(adminGroup)
                    .generate()
                    .asJson();
            }
        }

    }
</script>

<style scoped>

</style>
