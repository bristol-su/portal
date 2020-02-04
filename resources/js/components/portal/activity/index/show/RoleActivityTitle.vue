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
                role: null
            }
        },

        created() {
            this.loadRole();
        },

        methods: {
            loadRole() {
                this.$control.role().get(this.roleId)
                    .then(response => this.role = response.data)
                    .catch(error => this.$notify.alert('Could not load role ' + this.roleId + ': ' + error.message));
            }
        },

        computed: {
            title() {
                if(this.role === null) {
                    return 'Loading role information...';
                }
                return  'Activities for your position of ' + this.role.position.data.name + ' to ' + this.role.group.data.name;
            },

        }
    }
</script>

<style scoped>

</style>
