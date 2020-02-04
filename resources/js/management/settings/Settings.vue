<template>
    <div>
        <b-card no-body>
            <b-tabs card pills vertical>
                <b-tab active title="Additional Attributes">
                    <b-card-text>
                        <additional-attributes></additional-attributes>
                    </b-card-text>
                </b-tab>
                <b-tab title="Registration & Authentication Settings">
                    <b-card-text>
                        <authentication></authentication>
                    </b-card-text>
                </b-tab>
                <b-tab title="Welcome Screen">
                    <b-card-text>
                        <welcome></welcome>
                    </b-card-text>
                </b-tab>
                <b-tab title="Third Party Authentication">
                    <b-card-text>
                        <third-party-auth></third-party-auth>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>
</template>

<script>
    import AdditionalAttributes from '../settings/additionalattributes/AdditionalAttributes';
    import Authentication from './authentication/Authentication';
    import Welcome from './welcome/Welcome';
    import ThirdPartyAuth from './third-party-auth/ThirdPartyAuth';

    export default {
        name: "Settings",
        components: {ThirdPartyAuth, Authentication, AdditionalAttributes, Welcome},
        props: {},

        data() {
            return {}
        },

        methods: {},

        computed: {}
    }
</script>

<style scoped>

</style>
