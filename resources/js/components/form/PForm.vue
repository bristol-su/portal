<template>
    <validation-observer ref="observer" v-slot="{ invalid, handleSubmit }">
        <v-form v-if="hasActionAndMethod" :method="method" :action="action">
            <slot v-bind="{invalid: invalid}"></slot>
        </v-form>
        <v-form v-else @submit.prevent="$emit('submit')">
            <slot v-bind="{invalid: invalid, handleSubmit: handleSubmit}"></slot>
        </v-form>
    </validation-observer>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';

export default {
    name: "PForm",
    components: {
        ValidationProvider, ValidationObserver
    },
    mounted() {
        this.$refs.observer.setErrors(
            this.$tools.validation.server.all()
        );
    },
    props: {
        action: {
            required: false,
            type: String,
            default: null
        },
        method: {
            required: false,
            type: String,
            default: null
        }
    },
    computed: {
        hasActionAndMethod() {
            return this.action !== null && this.method !== null;
        }
    }
}
</script>

<style scoped>

</style>
