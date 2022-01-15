<template>
    <div>
        <p-select
            :select-options="connectionOptions"
            null-label="-- No connection --"
            :show-null-option="true"
            :id="service + '-select'"
            :label="'Connection for ' + service"
            :value="currentConnection"
            :required="true"
            tooltip="Choose a connection or create a new one."
            v-if="connectionsLoading"
        >
        </p-select>
        <div v-else>Loading...</div>
    </div>
</template>

<script>
    export default {
        name: "ServiceSelect",

        props: {
            service: {
                type: String,
                required: true
            },
            assignedServices: {
                type: Array,
                required: false,
                default() {
                    return [];
                }
            },
            moduleInstanceId: {
                required: true,
                type: Number
            }
        },

        data() {
            return {
                connections: [],
                connectionsLoading: false
            }
        },

        created() {
            this.loadConnections();
        },

        methods: {
            loadConnections() {
                this.connectionsLoading = true;
                this.$api.connection().allForService(this.service)
                    .then(response => this.connections = response.data)
                    .catch(error => this.$notify.alert('Could not load connections for ' + this.service + ': ' + error.message))
                    .then(() => this.connectionsLoading = false);
            },

            saveService(connectionId) {
                if (this.hasCurrentConnection) {
                    this.updateService(connectionId);
                } else {
                    this.createService(connectionId);
                }
            },

            updateService(connectionId) {
                this.$api.moduleInstanceServices().update(this.currentConnection.id, connectionId)
                    .then(response => {
                        this.$notify.success('Updated service connection');
                        this.$emit('updated', response.data);
                    })
                    .catch(error => this.$notify.alert('Could not update the service: ' + error.message));
            },

            createService(connectionId) {
                this.$api.moduleInstanceServices().create(this.service, connectionId, this.moduleInstanceId)
                    .then(response => {
                        this.$notify.success('Created service connection');
                        this.$emit('created', response.data);
                    })
                    .catch(error => this.$notify.alert('Could not create the service: ' + error.message));
            }
        },

        computed: {
            connectionOptions() {
                return this.connections.map(connection => {
                    return {id: connection.name, value: connection.id}
                })
            },
            currentConnection() {
                let services = this.assignedServices.filter(assignment => true);
                if(services.length > 0) {
                    return services[0];
                }
                return null;
            },
            hasCurrentConnection() {
                return this.currentConnection !== null;
            },
            value() {
                if(this.hasCurrentConnection) {
                    return this.currentConnection.connection_id;
                }
                return null;
            },
            loading() {
                return this.connectionsLoading;
            },
            doesActiveConnectionBelongToUser() {
                // If a user Can see the current connection then enable the dropdown
                return this.hasCurrentConnection && ! this.connectionOptions.filter(c => c.value === this.currentConnection.connection_id).length > 0;
            }
        },
    }
</script>

<style scoped>

</style>
