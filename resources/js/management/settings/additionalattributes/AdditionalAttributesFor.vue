<template>
    <div>
        <b-row>
            <b-col style="text-align: right;">
                <b-button size="lg" v-b-modal="modalId" variant="outline-info"><i class="fa fa-plus"/> New Attribute
                </b-button>
            </b-col>
        </b-row>
        <b-row>
            <b-col v-if="attributes.length > 0">
                <additional-attribute
                    :attribute="attribute"
                    :key="attribute.id"
                    v-for="attribute in attributes"></additional-attribute>
            </b-col>
            <b-col v-else>
                No attributes have yet been set. Add one below!
            </b-col>
        </b-row>


        <b-modal :id="modalId" title="Add a new attribute">
            <new-attribute :type="type" @createAttribute="createAttribute"></new-attribute>
        </b-modal>


    </div>
</template>

<script>
    import AdditionalAttribute from './AdditionalAttribute';
    import NewAttribute from './NewAttribute';

    export default {
        name: "AdditionalAttributesFor",
        components: {NewAttribute, AdditionalAttribute},
        props: {
            type: {
                required: true,
                type: String
            }
        },

        data() {
            return {
                attributes: []
            }
        },

        created() {
            this.$api.settings().get(this.settingKey, "[]")
                .then(response => this.attributes = (response.data.value === "[]"?[]:response.data.value))
                .catch(error => this.$notify.alert('Could not load attributes'));
        },

        methods: {
            createAttribute(attribute) {
                let newValue = this.attributes;
                newValue.push(attribute);
                this.$api.settings().set(this.settingKey, newValue)
                    .then(response => {
                        this.attributes = response.data.value;
                        this.$bvModal.hide(this.modalId);
                        this.$notify.success('Updated additional attributes');
                    })
                    .catch(error => this.$notify.alert('Could not create the new attribute: ' + error.message));
            }
        },

        computed: {
            settingKey() {
                return window.settingKeys.additional_attributes[this.type];
            },

            modalId() {
                return 'new-' + this.type + '-attribute';
            }
        }
    }
</script>

<style scoped>

</style>
