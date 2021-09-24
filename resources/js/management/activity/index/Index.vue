<template>
    <div>
        <b-table :fields="fields" :items="activities">
            <template v-slot:cell(actions)="data">
                <a :href="'/activity/' + data.item.id">
                    <b-button variant="secondary">View</b-button>
                </a>
                <b-button @click.prevent="processDelete(data)" variant="danger" v-if="canDelete">Delete</b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    export default {
        name: "Index",

        props: {
            activities: {
                required: true,
                type: Array,
                default: function() {
                    return [];
                }
            },
            canDelete: {
                required: false,
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                fields: [
                    'name',
                    'actions'
                ]
            }
        },

        methods: {
            processDelete(data) {
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this Activity?', {
                    title: 'Deleting Activity',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Delete',
                    cancelTitle: 'Cancel',
                    footerClass: 'p-2',
                    hideHeaderClose: true,
                    centered: true
                })
                    .then(confirmed => {
                        if (confirmed) {
                            this.$api.activity().delete(data.item.id)
                            .then(
                                this.$notify.success('Activity successfully deleted.'),
                                setTimeout(() => window.location.reload(), 3000)
                            )
                            .catch(error => this.$notify.alert('Could not delete the Activity: ' + error.message));
                        } else {
                            this.$notify.info('No Activities deleted');
                        }
                    })
                    .catch(error => this.$notify.alert('Could not delete the Activity: ' + error.message));
            }
        }
    }
</script>

<style scoped>

</style>
