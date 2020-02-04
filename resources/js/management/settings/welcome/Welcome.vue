<template>
    <div>
        <b-row>
            <b-col><h3>These settings are related to the welcome page.</h3></b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-card bg-variant="light">

                    <b-form-group
                        label-cols-lg="3"
                        label="Data Collection"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Ask for Registration Information"
                            label-align-sm="right"
                            label-for="registration-information"
                        >
                            <registration-information id="registration-information" @input="settings.registrationInformation = $event"></registration-information>
                        </b-form-group>

                        <b-form-group
                            label-cols-sm="3"
                            label="Ask for Registration Information"
                            label-align-sm="right"
                            label-for="registration-attributes"
                        >
                            <registration-attributes id="registration-attributes" @input="settings.registrationAttributes = $event"></registration-attributes>
                        </b-form-group>

                    </b-form-group>


                    <br/><hr/><br/>

                    <b-form-group
                        label-cols-lg="3"
                        label="Page Text"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Title of the page"
                            label-align-sm="right"
                            label-for="title-message"
                        >
                            <title id="title-message" @input="settings.titleMessage = $event"></title>
                        </b-form-group>

                        <b-form-group
                            label="Subtitle for the page"
                            label-align-sm="right"
                            label-for="subtitle-message"
                        >
                            <subtitle id="subtitle-message" @input="settings.subtitleMessage = $event"></subtitle>
                        </b-form-group>
                    </b-form-group>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import Title from './Title';
    import Subtitle from './Subtitle';
    import RegistrationInformation from './RegistrationInformation';
    import RegistrationAttributes from './RegistrationAttributes';
    export default {
        name: "Welcome",
        components: {RegistrationAttributes, RegistrationInformation, Subtitle, Title},
        props: {},

        data() {
            return {
                settings: {
                    registrationAttributeSelection: null,
                }
            }
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
