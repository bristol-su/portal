<template>
    <v-app>
        <slot></slot>
    </v-app>
</template>

<script>
import * as Tools from '@bristol-su/frontend-toolkit';

export default {
    name: "PApp",
    created() {
        // console.log(Tools.env.authentication.hasUser());
        console.log(Tools);
        console.log(this.$env);
    }
}
</script>

<style scoped>

</style>
