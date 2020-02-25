<template>
    <div>
        <b-form-select :options="dropdownOptions" class="mb-3" @input="moduleChanged">
            <!-- This slot appears above the options from 'options' prop -->
            <template v-slot:cell(first)="data">
                <option :value="null" disabled>-- Please select an option --</option>
            </template>
        </b-form-select>
    </div>
</template>

<script>
    export default {
        name: "ModuleType",

        props: {
            activityFor: {
                required: false,
                type: String,
                default: 'user'
            }
        },

        data() {
            return {
                options: []
            }
        },

        created() {
            this.loadModules();
        },

        methods: {
            loadModules() {
                return this.$api.modules().all()
                    .then(response => this.options = response.data)
                    .catch(error => this.$notify.alert('Could not load modules: ' + error.message));
            },

            moduleChanged(alias) {
                this.$emit('input', alias);
                this.$emit('module', this.options[alias]);
            }
        },

        computed: {
            dropdownOptions() {
                return Object.keys(this.options).filter(alias => {
                    let moduleFor = this.options[alias].for;
                    return moduleFor === 'user'
                        || (moduleFor === 'group' && (this.activityFor === 'group' || this.activityFor === 'role'))
                        || (moduleFor === 'role' && this.activityFor === 'role');
                }).map(alias => {
                    return {
                        value: alias,
                        text: this.options[alias].name
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
