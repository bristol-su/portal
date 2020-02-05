<template>
    <span>{{title}}</span>
</template>

<script>
    export default {
        name: "RoleActivityTitle",
        props: {
            roleId: {
                required: true,
            }
        },

        data() {
            return {
                role: null,
                position: null,
                group: null
            }
        },

        created() {
            this.loadRole();
        },

        methods: {
            loadRole() {
                this.$control.role().get(this.roleId)
                    .then(response => {
                        this.role = response.data;
                        this.loadGroup();
                        this.loadPosition();
                    })
                    .catch(error => this.$notify.alert('Could not load role ' + this.roleId + ': ' + error.message));
            },
            loadGroup() {
                this.$control.group().get(this.role.group_id)
                    .then(response => this.group = response.data)
                    .catch(error => this.$notify.alert('Could not load group ' + this.role.group_id + ': ' + error.message));
            },
            loadPosition() {
                this.$control.position().get(this.role.position_id)
                    .then(response => this.position = response.data)
                    .catch(error => this.$notify.alert('Could not load position ' + this.position.position_id + ': ' + error.message));
            }
        },

        computed: {
            title() {
                if(this.role === null) {
                    return 'Loading role information...';
                }
                let roleName = (this.role.data.role_name || (this.position === null ? '...loading...' : this.position.data.name ) );
                let groupName = (this.group === null ? '...loading...' : this.group.data.name );
                return 'Activities for your position of ' + roleName + ' to ' + groupName;
            },

        }
    }
</script>

<style scoped>

</style>
