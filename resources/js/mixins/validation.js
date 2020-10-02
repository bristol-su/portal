import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';

export default {
    components: {
        ValidationProvider, ValidationObserver
    },
    methods: {
        useRule(name, rule) {
            extend(name, rule);
        },
        useRules(rules) {
            Object.keys(rules).forEach(name => this.useRule(name, rules[name]));
        },
        setServerErrors(observer) {
            observer.setErrors(this.serverErrors);
        },
        hasServerErrors(key) {
            return this.serverErrors.hasOwnProperty(key) && this.serverErrors[key].length > 0;
        },
        serverErrors() {
            return this.$tools.validation.server.all()
        }
    }
}
