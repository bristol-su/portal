<template>
    <b-button-group>
        <b-button variant="outline-secondary" :disabled="disabled" @click="$emit('down')"><i class="fa fa-arrow-down"></i></b-button>
        <b-button :disabled="disabled" @click="$emit('up')"><i class="fa fa-arrow-up"></i></b-button>
    </b-button-group>
</template>

<script>
export default {
    name: "ModuleInstanceOrderChanger",
    props: {
        disabled: {
            default: false,
            type: Boolean
        }
    }
}
</script>

<style scoped>

</style>
