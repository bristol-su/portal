<template>

</template>

<script>
    export default {
        name: "Search",

        props: {
            value: {
                required: true,
                type: Array,
                default: function() {
                    return {};
                }
            }
        },

        computed: {
            parameters: {
                get() {
                    return this.value;
                },
                set(val) {
                    this.$emit('input', val);
                }
            }
        }
    }
</script>

<style scoped>

</style>
