<template>
    <v-row
        align="center"
        class="fill-height"
        justify="center">
        <v-col
            cols="12"
            md="4"
            sm="8">
            <v-alert v-if="emailSent" type="success">
                A fresh verification link has been sent to your email address.
            </v-alert>

            <v-form ref="form" action="/email/resend" method="POST">
                <v-card>
                    <v-card-title class="justify-center">
                        <span class="primary--text">Verify your email address</span>
                    </v-card-title>
                    <v-card-text>
                        <input id="_token" :value="csrf" name="_token" type="hidden"/>
                    </v-card-text>
                    <v-card-text>
                        <v-btn type="submit" block href="/login" text>Send me a new link</v-btn>
                    </v-card-text>
                </v-card>
            </v-form>
        </v-col>
    </v-row>
</template>


<script>
import csrf from 'Mixins/csrf';
import sitesettings from 'Mixins/sitesettings';

export default {
    name: "PRegister",

    mixins: [csrf, sitesettings],
    props: {
        emailSent: {
            required: false,
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            loading: false
        }
    },
    created() {
    },
    mounted() {
    },
    methods: {}
}
</script>

<style scoped>

</style>
