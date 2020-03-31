<template>
    <div>
        <div v-if="editing">
            <b-form-checkbox
                id="queueable"
                v-model="newQueueable">
                The action can run in the background
            </b-form-checkbox>
            <span><i class="fa fa-check" @click="updateQueueable"></i></span>
        </div>
        <div v-else>
            <span>{{statusText}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ActionShouldQueue",

        props: {
            action: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                newQueueable: null
            }
        },

        methods: {
            updateQueueable() {
                this.$api.actionInstance().update(this.action.id, {
                    should_queue: this.newQueueable
                })
                    .then(response => {
                        this.$notify.success('Updated queueable property');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update the queueable property: ' + error.message));
                this.editing = false;
            },
            edit() {
                this.newQueueable = this.action.should_queue;
                this.editing = true;
            }
        },

        computed: {
            statusText() {
                if(this.action.should_queue) {
                    return 'Queueable';
                }
                return 'Not Queueable'
            }
        }
    }
</script>

<style scoped>

</style>
