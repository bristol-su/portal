<template>
    <div>
        <div v-if="editing">
            <b-input type="text" size="sm" width="80%" v-model="newName">{{logic.name}}</b-input>
            <span><i class="fa fa-check" @click="updateName"></i></span>
        </div>
        <div v-else>
            <span>{{logic.name}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LogicName",

        props: {
            logic: {
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
                this.$api.logic().update(this.logic.id, {
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
                this.newName = this.logic.name;
                this.editing = true;
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
