<template>
    <div>
        <b-form-checkbox-group :options="providerOptions" :checked="value" @change="updateAttribute" name="enabled-providers" stacked>
        </b-form-checkbox-group>
    </div>
</template>

<script>
    export default {
        name: "EnabledProviders",

        data() {
            return {
                value: null,
                providers: [
                    'github',
                    'facebook',
                    'google',
                    'linkedin',
                    'twitter',
                    'reddit',
                    'sharepoint',
                    'spotify',
                    'trello',
                    'youtube',
                    'slack',
                    'instagram'
                ]
            }
        },

        mounted() {
            this.$api.settings().get(window.settingKeys.thirdPartyAuthentication.providers, '[]')
                .then(response => this.value = (response.data.value === '[]' ? [] : response.data.value))
                .catch(error => this.$notify.alert('Could not load current providers'));
        },

        methods: {
            updateAttribute(providers) {
                this.$emit('input', providers);
                if(providers !== this.value) {
                    this.value = providers;
                    this.$api.settings().set(window.settingKeys.thirdPartyAuthentication.providers, providers)
                        .then(response => this.$notify.success('Updated the current providers.'))
                        .catch(error => this.$notify.alert('Could not update the status of the current providers.'));
                }
            }
        },

        computed: {
            providerOptions() {
                return this.providers.map(provider => {
                    return {
                        text: provider[0] ? `${provider[0].toUpperCase()}${provider.substring(1)}` : '',
                        value: provider
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
