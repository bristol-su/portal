<template>
    <div>
        <div v-if="editing">
            <active-range @startDateUpdated="newStartDate = $event" @endDateUpdated="newEndDate = $event"></active-range>
            <span><i class="fa fa-check" @click="updateDates"></i></span>
        </div>
        <div v-else-if="alwaysActive">
            <span>Always Active</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
        <div v-else>
            <span>Active from {{this.activity.start_date | dateTimeFormat}} to {{this.activity.end_date | dateTimeFormat}}</span>
            <span><i class="fa fa-edit" @click="edit"></i></span>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import ActiveRange from './ActiveRange';

    export default {
        components: {ActiveRange},
        description: "ActivityActiveFromTo",

        props: {
            activity: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                editing: false,
                newStartDate: null,
                newEndDate: null
            }
        },

        filters: {
            dateTimeFormat(val) {
                return moment(val).format('LLLL')
            }
        },

        methods: {
            updateDates() {
                let newStartDate = this.newStartDate;
                if(newStartDate !== null && !moment(newStartDate, 'YYYY-MM-DD HH:mm:ss', true).isValid()) {
                    newStartDate += ':00';
                }
                let newEndDate = this.newEndDate;
                if(newEndDate !== null) {
                    newEndDate += ':00';
                }
                this.$api.activity().update(this.activity.id, {
                    start_date: newStartDate,
                    end_date: newEndDate
                })
                    .then(response => {
                        this.$notify.success('Updated activity timings');
                        window.location.reload();
                    })
                    .catch(error => this.$notify.alert('Could not update the activity timings: ' + error.message));
                this.editing = false;
            },
            edit() {
                this.newStartDate = this.activity.start_date;
                this.newEndDate = this.activity.end_date;
                this.editing = true;
            }
        },

        computed: {
            alwaysActive() {
                return this.activity.start_date === null && this.activity.end_date === null;
            }
        }
    }
</script>

<style scoped>

</style>
