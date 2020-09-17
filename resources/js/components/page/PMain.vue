<template>
    <v-main>
        <v-container fill-height>
            <v-row>
                <v-col>
                    <div>
                        <slot></slot>
                    </div>
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
