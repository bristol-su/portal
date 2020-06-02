<template>
        <b-form-input
            :disabled="disabled"
            :required="required"
            type="date"
            :value="dateValue"
            @input="updateValue"
            id="dob"></b-form-input>
    </b-form-group>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "DateOfBirth",

        props: {
            value: {
                required: false,
                default: null,
                type: String
            },
            disabled: {
                required: false,
                default: false,
                type: Boolean
            },
            required: {
                required: false,
                default: false,
                type: Boolean
            }
        },

        data() {
            return {}
        },

        methods: {
            updateValue(value) {
                let date = moment(value, 'YYYY-MM-DD');
                if(date.isValid()) {
                   this.$emit('input', date.format('DD-MM-YYYY'));
                }

            }
        },

        computed: {
            dateValue() {
                let date = moment(this.value, 'DD-MM-YYYY');
                if(date.isValid()) {
                    return date.format('YYYY-MM-DD');
                }
                return null;
            }
        }
    }
</script>

<style scoped>

</style>
