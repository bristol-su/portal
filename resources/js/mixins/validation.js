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
        }
    }
}
