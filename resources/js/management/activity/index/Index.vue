<template>
    <div>
        <div class="flex justify-end gap-2 self-end mb-2">
            <span>Actions: </span>
            <a :href="$tools.routes.basic.baseWebUrl() + '/activity/create'" class="text-primary hover:text-primary-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     content="Add Activity"
                     v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="sr-only">Add Activity</span>
            </a>
        </div>

        <p-table
            :columns="fields"
            :items="processedActivities"
            :viewable="true"
            :deletable="true"
            @view="viewActivity"
            @delete="deleteActivity">
        </p-table>
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
                    {label: 'Name', key: 'name'}
                ]
            }
        },

        methods: {
            viewActivity(activity) {
                window.location.href = '/activity/' + activity.id;
            },
            deleteActivity(activity) {
                this.$ui.confirm.delete('Deleting activity', 'Are you sure you want to delete the activity ' + activity.name + '?')
                    .then(() => {
                        this.$api.activity().delete(activity.id, 'deleting-activity-' + activity.id)
                            .then(response => {
                                this.$notify.success('Activity successfully deleted.');
                                window.location.reload();
                            })
                            .catch(error => this.$notify.alert('Could not delete the activity: ' + error.message))
                    })
            }
        },
        computed: {
            processedActivities() {
                return this.activities.map(activity => {
                    if(!activity.hasOwnProperty('_table')) {
                        activity._table = {}
                    }
                    activity._table.isDeleting = this.$isLoading('deleting-activity-' + activity.id);
                    return activity;
                });
            }
        }
    }
</script>

<style scoped>

</style>
