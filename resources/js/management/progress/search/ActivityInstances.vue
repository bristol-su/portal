<template>
    <b-form-input type="text" v-model="search">

    </b-form-input>
</template>

<script>
import {debounce} from 'lodash';

export default {
    name: "ActivityInstances",
    props: {
        activityId: {
            required: true,
            type: Number
        },
        loading: {
            required: false,
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            search: null
        }
    },
    watch: {
        search: debounce(function() {
            this.loadActivityInstances();
        }, 500)
    },
    methods: {
        loadActivityInstances() {
            if(this.search) {
                this.isLoading = true;
                this.$api.activityInstance().search(this.activityId, this.search)
                    .then(response => {
                        this.$emit('set', response.data)
                    })
                    .catch(error => this.$notify.alert('Could not load name search results: ' + error.response.data.message))
                    .finally(() => this.isLoading = false);
            } else {
                this.$emit('set', [])
            }

        }
    },
    computed: {
        isLoading: {
            get() {
                return this.loading;
            },
            set(value) {
                this.$emit('update:loading', value)
            }
        }
    }
}
</script>

<style scoped>

</style>

