<template>
    <b-container>
        <b-row>
            <b-col>
                <search v-model="searchParameters"></search>
            </b-col>
        </b-row>
        <b-row v-if="loading">
            <b-col>
                <b-spinner></b-spinner>
            </b-col>
        </b-row>
        <b-row v-else>
            <b-col>
                {{progress}}
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import Search from './Search';

    export default {
        name: "Progress",
        components: {Search},
        props: {
            activityId: {
                required: true,
                type: Number
            }
        },
        data() {
            return {
                searchParameters: {},
                pageParameters: {},
                progress: [],
                loading: false
            }
        },

        created() {
            this.loadProgress();
        },

        methods: {
            loadProgress() {
                this.loading = true;
                this.$api.progress().index(this.activityId, this.parameters)
                    .then(response => {
                        this.progress = response.data.data;
                    })
                    .catch(error => this.$notify.alert('Could not load the progress: ' + error.response.data.message))
                    .then(() => this.loading = false);

            }
        },

        computed: {
            parameters() {
                return Object.assign({}, this.searchParameters, this.pageParameters);
            }
        }

    }
</script>

<style scoped>

</style>
