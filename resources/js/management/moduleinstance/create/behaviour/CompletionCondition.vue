<template>
    <div style="border-style: solid">
        <b-form-select :options="completionConditionsOptions" class="mb-3" v-model="alias">
            <!-- This slot appears above the options from 'options' prop -->
            <template v-slot:cell(first)="data">
                <option :value="null" disabled>-- Please select an option --</option>
            </template>
        </b-form-select>

        <div v-if="conditionSelected">
            <b-input type="text" v-model="name" placeholder="Name of the condition"></b-input>
            <b-input type="text" v-model="description" placeholder="Description of the condition"></b-input>

            <p-dynamic-form :schema="selectedCondition.options" v-model="settings"></p-dynamic-form>

            <div style="text-align: right;">

                <b-button @click="saveConditions">Save Conditions</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CompletionCondition",

        props: {
            completionConditions: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },

        data() {
            return {
                alias: null,
                settings: {},
                name: '',
                description: ''
            }
        },

        watch: {
            alias(val) {
                if(val !== null) {
                    this.settings = {};
                }
            }
        },

        methods: {
            saveConditions() {
                this.$api.completionConditionInstances().create({
                    name: this.name,
                    alias: this.alias,
                    settings: this.settings,
                    description: this.description
                })
                    .then(response => {
                        this.$notify.success('Completion conditions saved');
                        this.$emit('input', response.data.id)
                    })
                    .catch(error => this.$notify.alert('Could not save completion conditions: ' + error.message));
            }
        },

        computed: {
            completionConditionsOptions() {
                return this.completionConditions.map(condition => {
                    return {
                        value: condition.alias,
                        text: condition.name
                    }
                });
            },

            conditionSelected() {
                return this.alias !== null;
            },

            selectedCondition() {
                if (this.conditionSelected) {
                    return this.completionConditions.filter(condition => {
                        return condition.alias === this.alias;
                    })[0];
                }
                return null;
            }
        }
    }
</script>

<style scoped>

</style>
