<template>
    <div>
        <b-alert v-model="show" variant="danger" dismissible>
            {{label}}: <span v-html="messagesAsHtml"></span>
        </b-alert>
    </div>
</template>

<script>
    export default {
        name: "ValidationAlert",

        props: {
            label: {
                required: true,
                type: String
            },
            message: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                show: true
            }
        },

        computed: {
            messagesAsHtml() {
                if(this.message.length === 1) {
                    return this.message[0]
                }
                return this.message.map(m => {
                    return '<li>' + m + '</li>';
                })
            }
        }
    }
</script>

<style scoped>

</style>
