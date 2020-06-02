<template>
    <span>{{title}}</span>
</template>

<script>
    export default {
        name: "RoleActivityTitle",
        props: {
            group: {
                required: true,
            },
            role: {
                required: true
            }
        },

        data() {
            return {
                position: null,
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
