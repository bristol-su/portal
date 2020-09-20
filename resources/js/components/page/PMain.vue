<template>
    <v-main>
        <v-container fill-height class="align-start">
            <v-row class="fill-height">
                <v-col class="fill-height">
                    <slot></slot>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>

export default {
    name: "PMain"
}
</script>

<style scoped>

</style>
