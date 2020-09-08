<template>
    <v-main>
        <v-container fill-height>
            <v-row>
                <v-col>
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
