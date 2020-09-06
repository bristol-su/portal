<template>
    <v-select
        multiple
        :options="options"
        label="name"
        :reduce="m => m.id" v-model="selected"
    >
    </v-select>
</template>

<script>

import vSelect from 'vue-select';

export default {
    name: "ModuleInstances",
    components: {vSelect},
    props: {
        options: {
            required: false,
            type: Array,
            default: function () {
                return [];
            }
        },
        value: {
            required: false,
            type: Array,
            default: function () {
                return [];
            }
        }
    },

    computed: {
        selected: {
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
