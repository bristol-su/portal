export default {
    computed: {
        csrf() {
            return document.head.querySelector('meta[name="csrf-token"]');
        }
    }
}
