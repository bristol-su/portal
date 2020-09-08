<template>
    <div>
        <component :is="config"></component>
    </div>
</template>

<script>
export default {
    name: 'Wrapper',
    key: 'Wrapper',
    props: {
        config: {
            type: Object,
            default: function() {
                return {key: 'default'}
            }
        },
        components: {
            type: Object,
            default: function() {
                return {}
            }
        },
    },
    created() {
        this.$options.components = this.components;
    }
}
</script>

<style scoped>

</style>
