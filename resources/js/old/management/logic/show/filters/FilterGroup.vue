<template>
    <div>
        <div v-for="filter in filters" :key="filter.id">
            <data-item title="Name">{{filter.name}}</data-item>
            <data-item title="Filter">{{filter.alias}}</data-item>
            <data-item title="Tests">{{filter.for}}</data-item>
            <data-item title="Settings">{{filter.settings}}</data-item>
            <data-item title="Actions"><b-button variant="danger" size="sm" @click="deleteFilter(filter)">Delete</b-button></data-item>
            <hr/>
        </div>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    export default {
        name: "FilterGroup",
        components: {DataItem},
        props: {
            filters: {
                required: true,
                type: Array,
                default: function() {
                    return [];
                }
            }
        },

        methods: {
            deleteFilter(filter) {
                this.$api.logic().removeFilter(filter.logic_id, filter.id)
                    .then(response => {
                        this.$notify.success('Removed filter');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not remove the filter: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
