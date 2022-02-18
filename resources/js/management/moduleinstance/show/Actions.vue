<template>
    <div>
        <div class="flex justify-end gap-2 self-end mb-2">
            <span>Actions: </span>
            <a :href="$tools.routes.basic.baseWebUrl() + '/activity/' + moduleInstance.activity_id + '/module-instance/' + moduleInstance.id + '/action/create'"
               class="text-primary hover:text-primary-dark">
                <svg v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}"
                     class="h-6 w-6" content="Add Action" fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"/>
                </svg>
                <span class="sr-only">Add Action</span>
            </a>
        </div>

        <p-table
            :columns="fields"
            :deletable="true"
            :viewable="true"
            :items="actions"
            @delete="deleteAction"
            @view="viewAction">

        </p-table>
    </div>
</template>

<script>
export default {
    name: "Actions",
    props: {
        module: {
            required: true,
            type: Object
        },
        moduleInstance: {
            required: true,
            type: Object
        },
    },

    data() {
        return {
            fields: [
                {label: 'Name', key: 'name'}
            ],
        }
    },

    computed: {
        actions() {
            return this.moduleInstance.action_instances;
        }
    },

    methods: {
        deleteAction(action) {
            this.$ui.confirm.delete('Deleting action', 'Are you sure you want to delete the action ' + action.name + '?')
                .then(() => {
                    this.$api.action().delete(action.id, 'deleting-action-' + action.id)
                        .then(response => {
                            this.$notify.success('Deleted action');
                            window.location.reload();
                        })
                        .catch(error => this.$notify.alert('Could not delete the action: ' + error.message));
                })
        },
        viewAction(action) {
            window.location.href = '/action/' + action.id;
        }
    }
}
</script>

<style scoped>

</style>
