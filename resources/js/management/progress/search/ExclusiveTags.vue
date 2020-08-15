<template>
    <div>
        <slot v-bind:first="first" v-bind:second="second">

        </slot>
    </div>
</template>

<script>
export default {
    name: "ExclusiveTags",
    props: {
        options: {
            required: false,
            type: Array,
            default: function() {
                return [];
            }
        },
        firstSelected: {
            required: false,
            type: Array,
            default: function() {
                return [];
            }
        },
        secondSelected: {
            required: false,
            type: Array,
            default: function() {
                return [];
            }
        },
        optionsKey: {
            required: true,
            type: String
        }
    },

    computed: {
        first() {
            return this.options.filter(option => !this.secondSelected.includes(option[this.optionsKey]))
        },
        second() {
            return this.options.filter(option => !this.firstSelected.includes(option[this.optionsKey]))
        }
    }
}
</script>

<style scoped>

</style>
