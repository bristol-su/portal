<template>
    <div>
        {{name}}
    </div>
</template>

<script>
export default {
    name: "ActivityInstanceProgressModuleEntry",
    props: {
        name: {
            required: true,
            type: String
        },
        visible: {
            required: true,
            type: Boolean
        },
        active: {
            required: true,
            type: Boolean
        },
        percentage: {
            required: true,
            type: Number
        }
    }
}
</script>

<style scoped>

</style>
