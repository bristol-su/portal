export default {
    methods: {
        getSetting(key) {
            if(this._siteSettings.hasOwnProperty(key)) {
                return this._siteSettings[key];
            }
            return null;
        }
    },
    computed: {
        _siteSettings() {
            return window.portal.siteSettings;
        }
    },
    data() {
        return {
            settingKeys: {
                authentication: {
                    identifier: {
                        key: 'authentication.identifier.key',
                        label: 'authentication.identifier.label',
                        validation: 'authentication.identifier.validation',
                    }
                }
            }
        }
    }
}
