<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <b-card no-body>
                <b-tabs card pills vertical>
                    <b-tab active title="All True">
                        <b-card-text>
                            <filter-group :filters="allTrue"></filter-group>
                        </b-card-text>
                        <add-filter @addFilter="addFilter($event, 'all_true')" title="Add a new filter - Always True"></add-filter>
                    </b-tab>
                    <b-tab active title="All False">
                        <b-card-text>
                            <filter-group :filters="allFalse"></filter-group>
                        </b-card-text>
                        <add-filter @addFilter="addFilter($event, 'all_false')" title="Add a new filter - Always False"></add-filter>
                    </b-tab>
                    <b-tab active title="Any True">
                        <b-card-text>
                            <filter-group :filters="anyTrue"></filter-group>
                        </b-card-text>
                        <add-filter @addFilter="addFilter($event, 'any_true')" title="Add a new filter - Any True"></add-filter>
                    </b-tab>
                    <b-tab active title="Any False">
                        <b-card-text>
                            <filter-group :filters="anyFalse"></filter-group>
                        </b-card-text>
                        <add-filter @addFilter="addFilter($event, 'any_false')" title="Add a new filter - Any False"></add-filter>
                    </b-tab>
                </b-tabs>
            </b-card>
        </div>

    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    import FilterGroup from "./FilterGroup";
    import AddFilter from '../../create/filter/AddFilter';

    export default {
        name: "Filters",
        components: {AddFilter, FilterGroup, DataItem},
        props: {
            logicId: {
                required: true,
                type: Number
            }
        },

        data() {
            return {
                filters: [],
                loading: true
            }
        },

        created() {
            this.loadFilters();
        },

        methods: {
            loadFilters() {
                this.$api.filters().getBelongingToLogic(this.logicId)
                    .then(response => this.filters = response.data)
                    .catch(error => this.$notify.alert('Could not load filters: ' + error.message))
                    .then(() => this.loading = false);
            },
            addFilter(filter, type) {
                this.$api.logic().attachFilter(this.logicId, filter.id, type)
                    .then(response => {
                        this.$notify.success('Filter attached to logic');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not attach filter to logic: ' + error.message));
            }
        },

        computed: {
            allTrue() {
                return this.filters.filter(filter => {
                    return filter.logic_type === 'all_true';
                })
            },
            allFalse() {
                return this.filters.filter(filter => {
                    return filter.logic_type === 'all_false';
                })
            },
            anyTrue() {
                return this.filters.filter(filter => {
                    return filter.logic_type === 'any_true';
                })
            },
            anyFalse() {
                return this.filters.filter(filter => {
                    return filter.logic_type === 'any_false';
                })
            },
        }


    }
</script>

<style scoped>

</style>
