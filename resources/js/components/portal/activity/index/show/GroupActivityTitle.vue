<template>
    <span>{{title}}</span>
</template>

<script>
    export default {
        name: "GroupActivityTitle",
        props: {
            group: {
                required: true,
            }
        },

        computed: {
            title() {
                if(this.group === null) {
                    return 'Loading group membership information...';
                }
               return  'Activities for your membership to ' + this.group.data.name;
            },

        }
    }
</script>

<style scoped>

</style>
