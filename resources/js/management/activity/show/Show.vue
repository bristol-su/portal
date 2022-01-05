<template>
    <div style="text-align: left;">

        <div>

            <p-tabs>
                <p-tab title="Activity Info">
                    <activity-form :old-activity="activity" @submit="updateActivity" :busy="$isLoading('updating-activity')">

                    </activity-form>
                </p-tab>

                <p-tab title="Modules">
                    <module-index
                        :can-delete="canDelete"
                        :activity="activity">

                    </module-index>
                </p-tab>
            </p-tabs>

        </div>


    </div>
</template>

<script>
    import ModuleIndex from './module-instance/index/Index';
    import ActivityForm from '../ActivityForm';

    export default {
        name: "Show",
        props: {
            activity: {
                required: true,
                type: Object
            },
            canDelete: {
                required: false,
                type: Boolean,
                default: function() {
                    return false;
                }
            }
        },

        components: {
            ActivityForm,
            ModuleIndex,
        },

        methods: {
            updateActivity(data) {
                this.$api.activity().update(this.activity.id, {
                    name: data.name,
                    description: data.description,
                    slug: data.slug,
                    for_logic: data.for_logic,
                    admin_logic: data.admin_logic,
                    start_date: data.range?.lower,
                    end_date: data.range?.upper,
                    enabled: data.active
                }, 'updating-activity')
                    .then(response => {
                        this.$notify.success('Activity updated');
                        window.location.href = '/activity/' + response.data.id;
                    })
                    .catch(error => this.$notify.alert('Could not update activity: ' + error.message))
            }
        }

    }
</script>

<style scoped>
    .view-header {
        font-size: 25px;
    }

    .show-card {
        margin-top: 10px;
        margin-bottom: 5px;
    }
</style>
