<template>
    <div>
        <div v-if="editing">
            <b-input type="text" size="sm" width="80%" v-model="newName">{{action.name}}</b-input>
            <span><i class="fa fa-check" @click="updateName"></i></span>
        </div>
        <div v-else>
            <span>{{action.name}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ActionName",

        props: {
            action: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                newName: null
            }
        },

        methods: {
            updateName() {
                this.$api.actionInstance().update(this.action.id, {
                    name: this.newName
                })
                    .then(response => {
                        this.$notify.success('Updated name');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update the name: ' + error.message));
                this.editing = false;
            },
            edit() {
                this.newName = this.action.name;
                this.editing = true;
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
