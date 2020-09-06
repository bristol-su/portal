export default {
    props: {
        errors: {
            required: false,
            type: Object,
            default: function() {
                return {};
            }
        }
    }
}
