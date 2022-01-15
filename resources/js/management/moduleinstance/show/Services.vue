<template>
    <div>
        <div>
            <p-api-form
                :schema="servicesSchema"
                button-text="Update"
                :busy="$isLoading('updating-services')"
                busy-text="Saving services"
                @submit="updateServices"
                :initial-data="initialData"
            ></p-api-form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Services",
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
                connections: []
            }
        },

        mounted() {
            this.loadConnections();
        },

        methods: {
            loadConnections() {
                this.$api.connection().index('loading-connections')
                    .then(response => this.connections = response.data)
                    .catch(error => this.$notify.alert('Could not load connections'));
            },
            updateServices(data) {
                this.$api.moduleInstanceServices().updateMany(this.moduleInstance.id, data, 'updating-services')
                    .then(response => this.$notify.success('Services updated'))
                    .catch(error => this.$notify.alert('Could not update services: ' + error.message));
            }
        },

        computed: {
            initialData() {
                let initialData = {};
                this.moduleInstance.module_instance_services.forEach(service => initialData[service.ability] = service.logic_id);
                return initialData;
            },
            servicesSchema() {
                let optionalGroup = this.$tools.generator.group.newGroup('Participant');
                let requiredGroup = this.$tools.generator.group.newGroup('Admin');

                this.module.services.optional.forEach(service => {
                    optionalGroup.withField(
                        this.$tools.generator.field.select(service.ability)
                            .label(service.name)
                            .hint(service.description)
                            .setOptions(this.connections.filter(c => c.connector.service === this.service).map(c => {
                                return {id: c.id, name: c.name}
                            }))
                    )
                });
                this.module.services.required.forEach(service => {
                    requiredGroup.withField(
                        this.$tools.generator.field.select(service.ability)
                            .label(service.name)
                            .hint(service.description)
                            .setOptions(this.connections.filter(c => c.connector.service === this.service).map(c => {
                                return {id: c.id, name: c.name}
                            }))
                    )
                });

                return this.$tools.generator.form.newForm('Services')
                    .withGroup(optionalGroup)
                    .withGroup(requiredGroup)
                    .generate()
                    .asJson();
            }
        }

    }
</script>

<style scoped>

</style>
