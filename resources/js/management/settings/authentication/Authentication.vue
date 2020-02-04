<template>
    <div>
        <b-row>
            <b-col><h3>These settings are related to controlling how users register and log into the site.</h3></b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-card bg-variant="light">


                    <b-form-group
                        label-cols-lg="3"
                        label="Registration Identifier"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Attribute to use for registration:"
                            description="What should users log in with?"
                            label-align-sm="right"
                            label-for="registration-attribute-selection"
                        >
                            <registration-identifier-selection id="registration-attribute-selection" @input="settings.registrationIdentifierSelection = $event"></registration-identifier-selection>
                        </b-form-group>


                        <b-form-group
                            label-cols-sm="3"
                            label="Validation for the attribute:"
                            label-align-sm="right"
                            description="What validation should be applied to this attribute?"
                            label-for="registration-attribute-validation"
                            v-if="settings.registrationAttributeSelection !== null"
                        >
                            <registration-identifier-validation id="registration-attribute-validation" @input="settings.registrationIdentifierValidation = $event"></registration-identifier-validation>
                        </b-form-group>

                    </b-form-group>

                    <br/><hr/><br/>

                    <b-form-group
                        label-cols-lg="3"
                        label="Password"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Password Validation"
                            label-align-sm="right"
                            label-for="password-validation"
                        >
                            <password-validation id="password-validation" @input="settings.passwordValidation = $event"></password-validation>
                        </b-form-group>

                    </b-form-group>

                    <br/><hr/><br/>

                    <b-form-group
                        label-cols-lg="3"
                        label="Account Verification"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Email Verification Required?"
                            label-align-sm="right"
                            label-for="email-verification-required"
                        >
                            <verification-enabled id="email-verification-required" @input="settings.verificationEnabled = $event"></verification-enabled>
                        </b-form-group>

                    </b-form-group>

                    <br/><hr/><br/>


                    <b-form-group
                        label-cols-lg="3"
                        label="Who can register?"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Already in data?"
                            label-align-sm="right"
                            label-for="who-can-register"
                        >
                            <already-in-data id="who-can-register" @input="settings.alreadyInData = $event"></already-in-data>
                        </b-form-group>

                        <b-form-group
                            label-cols-sm="3"
                            label="Already in control?"
                            label-align-sm="right"
                            label-for="already-in-control"
                        >
                            <already-in-control id="already-in-control" @input="settings.alreadyInControl = $event"></already-in-control>
                        </b-form-group>
                    </b-form-group>

                    <br/><hr/><br/>

                    <b-form-group
                        label-cols-lg="3"
                        label="Registration Messaging"
                        label-size="lg"
                        label-class="font-weight-bold pt-0"
                        class="mb-0"
                    >
                        <b-form-group
                            label-cols-sm="3"
                            label="Message if user not found in data"
                            description="Message to show if the user is not in data, but should be"
                            label-align-sm="right"
                            label-for="not-in-data-message"
                        >
                            <not-in-data id="not-in-data-message" @input="settings.notInDataMessage = $event"></not-in-data>
                        </b-form-group>

                        <b-form-group
                            label-cols-sm="3"
                            label="Message if user not found in control"
                            description="Message to show if the user is not in control, but should be"
                            label-align-sm="right"
                            label-for="not-in-control-message"
                        >
                            <not-in-control id="not-in-control-message" @input="settings.notInControlMessage = $event"></not-in-control>
                        </b-form-group>

                        <b-form-group
                            label-cols-sm="3"
                            label="Message if user is already registered"
                            description="Message to show if the user is already registered"
                            label-align-sm="right"
                            label-for="already-registered-message"
                        >
                            <already-registered id="already-registered-message" @input="settings.alreadyRegisteredMessage = $event"></already-registered>
                        </b-form-group>
                    </b-form-group>

                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import RegistrationIdentifierSelection from './Fields/registration_identifier/RegistrationIdentifierSelection';
    import RegistrationIdentifierValidation from './Fields/registration_identifier/RegistrationIdentifierValidation';
    import PasswordValidation from './Fields/password/PasswordValidation';
    import VerificationEnabled from './Fields/verification/VerificationEnabled';
    import AlreadyInData from './Fields/authorization/AlreadyInData';
    import AlreadyInControl from './Fields/authorization/AlreadyInControl';
    import AlreadyRegistered from './Fields/messages/AlreadyRegistered';
    import NotInControl from './Fields/messages/NotInControl';
    import NotInData from './Fields/messages/NotInData';

    export default {
        name: "Authentication",
        components: {
            NotInData,
            NotInControl,
            AlreadyRegistered,
            AlreadyInControl,
            AlreadyInData,
            VerificationEnabled,
            PasswordValidation,
            RegistrationIdentifierValidation,
            RegistrationIdentifierSelection},
        props: {},

        data() {
            return {
                settings: {
                    registrationIdentifierSelection: null,
                    registrationIdentifierValidation: null,
                    passwordValidation: null,
                    verificationEnabled: null,
                    alreadyInData: null,
                    alreadyInControl: null,
                    alreadyRegisteredMessage: null,
                    notInControlMessage: null,
                    notInDataMessage: null
                }
            }
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
