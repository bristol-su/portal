<template>
        <b-form-group
            :description="permission.description"
            :id="permission.ability + '-label'"
            :label="permission.name"
            :label-for="permission.ability">
            <b-form-select @input="savePermission" :value="currentValue" :options="options" class="mb-3">
                <template v-slot:first>
                    <option :value="null">-- Give permission to noone --</option>
                </template>
            </b-form-select>
        </b-form-group>


</template>

<script>
    export default {
        name: "PermissionLogicSelect",

        props: {
            permission: {
                required: true,
                type: Object
            },
            logic: {
                required: false,
                type: Array,
                default() {
                    return [];
                }
            },
            assignedPermissions: {
                required: false,
                type: Array,
                default() {
                    return [];
                }
            },
            moduleInstanceId: {
                required: true,
                type: Number
            }
        },

        data() {
            return {
            }
        },

        methods: {
            savePermission(logicId) {
                if(this.currentModuleInstancePermission !== null) {
                    this.updatePermission(logicId);
                } else {
                    this.createPermission(logicId);
                }
            },

            updatePermission(logicId) {
                if(logicId !== null) {
                    this.$api.moduleInstancePermissions().update(this.currentModuleInstancePermission.id, logicId)
                        .then(response => {
                            this.$notify.success('Permission updated');
                        })
                        .catch(error => this.$notify.alert('Could not update permission: ' + error.message));
                } else {
                    this.$api.moduleInstancePermissions().delete(this.currentModuleInstancePermission.id, logicId)
                        .then(response => {
                            this.$notify.success('Permission updated');
                            window.location.reload();
                        })
                        .catch(error => this.$notify.alert('Could not update permission: ' + error.message));
                }

            },

            createPermission(logicId) {
                if(logicId !== null) {
                    this.$api.moduleInstancePermissions().create(
                        this.permission.ability, logicId, this.moduleInstanceId)
                        .then(response => {
                            this.$notify.success('Permission created');
                        })
                        .catch(error => this.$notify.alert('Could not create permission: ' + error.message));
                }
            }
        },

        computed: {
            options() {
                return this.logic.map(logic => {
                    return {text: logic.name, value: logic.id}
                });
            },
            currentModuleInstancePermission() {
                let assignedPermissions = this.assignedPermissions.filter(per => per.ability === this.permission.ability);
                if(assignedPermissions.length > 0) {
                    return assignedPermissions[0];
                }
                return null;
            },

            currentValue() {
                return (this.currentModuleInstancePermission === null?null:this.currentModuleInstancePermission.logic_id);
            },
        }
    }
</script>

<style scoped>

</style>
