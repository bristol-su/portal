<template>
    <div>
        <b-form-select :disabled="disabled" v-model="currentGroup" :options="options"></b-form-select>
        <b-button @click="$emit('new')" pill variant="outline-secondary">
            <i class="fa fa-plus" />
        </b-button>
    </div>
</template>

<script>
export default {
    name: "ModuleInstanceGroupSelect",
    props: {
        groupings: {
            type: Array,
            default: function () {
                return [];
            }
        },
        groupingId: {
            default: null
        },
        disabled: {
            default: false,
            type: Boolean
        }
    },
    computed: {
        currentGroup: {
            set(groupId) {
                this.$emit('update', groupId);
            },
            get() {
                return this.groupingId;
            }
        },
        options() {
            let groupings = this.groupings.map(grouping => {
                return {value: grouping.id, text: grouping.heading}
            });
            groupings.unshift({value: null, text: '--No Group--'});
            return groupings;
        }
    }
}
</script>

<style scoped>

</style>
