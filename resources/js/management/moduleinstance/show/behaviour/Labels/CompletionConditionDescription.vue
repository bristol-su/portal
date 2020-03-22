<template>
    <div>
        <div v-if="editing">
            <b-input type="text" size="sm" width="80%" v-model="newDescription">{{completionCondition.description}}</b-input>
            <span><i class="fa fa-check" @click="updateDescription"></i></span>
        </div>
        <div v-else>
            <span>{{completionCondition.description}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CompletionConditionDescription",

        props: {
            completionCondition: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                newDescription: null
            }
        },

        methods: {
            updateDescription() {
                this.$api.completionConditionInstances().update(this.completionCondition.id, {
                    description: this.newDescription
                })
                    .then(response => {
                        this.$notify.success('Updated description');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update the description: ' + error.message));
                this.editing = false;
            },
            edit() {
                this.newDescription = this.completionCondition.description;
                this.editing = true;
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
