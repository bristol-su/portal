<template>
    <div role="tablist">
        <b-card no-body class="mb-1" v-for="history in histories" :key="history.id">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block href="#" v-b-toggle="'history-' + history.id" :variant="(history.success ? 'outline-success' : 'outline-danger')">
                    <i class="fa" :class="(history.success ? 'fa-check-circle' : 'fa-times-circle')"></i> {{history.message}} - {{history.created_at | datetimeFormat}}
                </b-button>
            </b-card-header>
            <b-collapse :id="'history-' + history.id" accordion="history" role="tabpanel">
                <b-card-body>
                    <action-history :history="history"></action-history>
                </b-card-body>
            </b-collapse>
        </b-card>
    </div>
</template>

<script>
    import ActionHistory from './ActionHistory';
    import moment from 'moment';
    export default {
        name: "ActionHistories",

        components: {ActionHistory},

        props: {
            actionInstance: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                histories: []
            }
        },

        filters: {
            datetimeFormat(val) {
                return moment(val).format('LLLL');
            }
        },

        created() {
            this.loadHistory();
        },

        methods: {
            loadHistory() {
                this.$api.actionInstanceHistory().forActionInstance(this.actionInstance.id)
                    .then(response => this.histories = response.data)
                    .catch(error => this.$notify.alert('Could not load history: ' + error.message));
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
