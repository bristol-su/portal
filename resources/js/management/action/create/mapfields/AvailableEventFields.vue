<template>
    <div>
        <p-table
            :columns="fields"
            :items="tableRows">
            <template #actions="{row}">
                <a href="#" @click="copyToClipboard(row.placeholder)">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}" content="copy"
                         xmlns="http://www.w3.org/2000/svg">
                      <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"/>
                    </svg>
                    <span class="sr-only">Copy</span>
                </a>
            </template>
        </p-table>
    </div>
</template>

<script>
export default {
    name: "AvailableEventFields",

    props: {
        actionInstance: {
            required: true,
            type: Object
        }
    },

    data() {
        return {
            fields: [
                {label: 'Placeholder', key: 'placeholder'},
                {label: 'Help', key: 'helptext'}
            ],
        }
    },

    filters: {
        formatAsField(val) {
            return '{{event:' + val + '}}';
        }
    },

    methods: {
        copyToClipboard(field) {
            this.$clipboard(field);
            this.$notify.success('Field copied to clipboard.');
        },

        makeField(val) {
            return '{{event:' + val + '}}';
        }
    },

    computed: {
        eventFields() {
            return this.actionInstance.event_fields;
        },
        tableRows() {
            return Object.keys(this.eventFields)
                .map(key => {
                    return {
                        ...this.eventFields[key],
                        'key': key,
                        'placeholder': this.makeField(key)
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
