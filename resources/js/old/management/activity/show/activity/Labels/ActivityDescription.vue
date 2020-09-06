<template>
    <div>
        <div v-if="editing">
            <b-input type="text" size="sm" width="80%" v-model="newDescription">{{activity.description}}</b-input>
            <span><i class="fa fa-check" @click="updateDescription"></i></span>
        </div>
        <div v-else>
            <span>{{activity.description}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ActivityDescription",

        props: {
            activity: {
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
                this.$api.activity().update(this.activity.id, {
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
                this.newDescription = this.activity.description;
                this.editing = true;
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
