<template>
    <div>
        <div v-if="loading">
            Loading...
        </div>
        <div v-if="editing">
            <v-logic :value="logicId" @input="updateLogic"></v-logic>
        </div>
        <div v-else>
            <data-item title="Name">
                {{logic.name}}
            </data-item>
            <data-item title="Description">
                {{logic.description}}
            </data-item>
            <data-item title="View">
                <a :href="url"><b-button variant="secondary" size="sm">View</b-button></a>
            </data-item>
            <data-item title="Edit">
                <b-button variant="secondary" size="sm" @click="edit">Edit</b-button>
            </data-item>
        </div>
    </div>
</template>

<script>
    import DataItem from "../../../../utilities/DataItem";
    export default {
        name: "Logic",
        components: {DataItem},
        props: {
            logicId: {
                required: true,
                type: Number
            },
            attribute: {
                required: true,
                type: String
            },
            moduleInstanceId: {
                required: true,
                type: Number
            }
        },

        data() {
            return {
                logic: {},
                loading: true,
                editing: false
            }
        },

        created() {
            this.loadLogic();
        },

        methods: {
            edit() {
                this.editing = true;
            },
            loadLogic() {
                this.$api.logic().get(this.logicId)
                    .then(response => this.logic = response.data)
                    .catch(error => this.$notify.alert('Could not load logic information: ' + error.message))
                    .then(() => this.loading = false);
            },
            updateLogic(logicId) {
                let updated = {};
                updated[this.attribute] = logicId;
                this.$api.moduleInstances().update(this.moduleInstanceId, updated)
                    .then(response => window.location.reload())
                    .catch(error => this.$notify.alert('Could not update logic: ' + error.message));
            }
        },

        computed: {
            url() {
                return process.env.MIX_APP_URL + '/logic/' + this.logic.id;
            }
        }
    }
</script>

<style scoped>

</style>
