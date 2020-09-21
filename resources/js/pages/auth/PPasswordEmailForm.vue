<template>
    <v-row
        justify="center"
        align="center"
        class="fill-height">
        <v-col
            cols="12"
            sm="8"
            md="4">
            <validation-observer ref="observer" v-slot="{ invalid, handleSubmit }">
                <v-form method="POST" :action="route" ref="form">
                    <v-card>
                        <v-card-title class="justify-center">
                            <span class="primary--text">Reset Password</span>
                        </v-card-title>
                        <v-card-text>
                            <v-alert type="success" v-if="status !== null && status !== ''">
                                {{status}}
                            </v-alert>
                            <input type="hidden" :value="csrf" name="_token" id="_token"/>

                            <validation-provider
                                v-slot="{ errors }"
                                name="identifier"
                                rules="required">

                                <v-text-field
                                    :label="getSetting(settingKeys.authentication.identifier.label)"
                                    id="identifier"
                                    name="identifier"
                                    v-model="identifier"
                                    prepend-icon="mdi-account"
                                    :error-messages="errors"
                                    type="text"
                                    :autofocus="!hasServerErrors('identifier')"
                                ></v-text-field>
                            </validation-provider>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" block type="submit" aria-label="Send Password Reset Link" :disabled="invalid"
                                   :loading="loading">
                                <v-icon>mdi-arrow-right</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-btn text block href="/login">Take me back</v-btn>
                        </v-card-text>
                    </v-card>
                </v-form>
            </validation-observer>
        </v-col>
    </v-row>
</template>

<script>
import csrf from 'Mixins/csrf';
import validation from 'Mixins/validation';
import sitesettings from 'Mixins/sitesettings';

export default {
    name: "PPasswordEmailForm",
    data() {
        return {
            identifier: null,
            loading: false
        }
    },
    mixins: [csrf, validation, sitesettings],
    props: {
        route: {
            required: true,
            type: String
        },
        status: {
            required: false,
            type: String,
            default: null
        },
    },
    mounted() {
        this.setServerErrors(this.$refs.observer);
    }
}
</script>

<style scoped>

</style>
