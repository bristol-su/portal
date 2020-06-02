<template>
    <div>
        <b-row>
            <b-col><h3>These settings are related to registering and logging in with third parties.</h3></b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-card bg-variant="light">

                    <b-form-group
                        label-cols-lg="3"
                        label="Providers"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Enabled Providers"
                            label-align-sm="right"
                            label-for="enabled-providers"
                            description="Providers that can be used for log in. Client ID and secret must be defined in .env"
                        >
                            <enabled-providers id="enabled-providers" @input="settings.enabledProviders = $event"></enabled-providers>
                        </b-form-group>

                    </b-form-group>

<!--                    <br/><hr/><br/>-->

                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import EnabledProviders from './EnabledProviders';
    export default {
        name: "ThirdPartyAuth",
        components: {EnabledProviders},
        props: {},

        data() {
            return {
                settings: {
                    enabledProviders: [],
                }
            }
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
