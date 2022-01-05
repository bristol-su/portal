<template>
    <div>
        <activity-form @submit="createNewActivity" :busy="$isLoading('creating-activity')">

        </activity-form>
    </div>
</template>

<script>
    import ActivityForm from '../ActivityForm';

    export default {
        name: "Create",
        components: {ActivityForm},
        data() {
            return {
                name: '',
                description: '',
                slug: '',
                type: 'open',
                activity_for: 'user',
                for_logic: null,
                admin_logic: null,
                start_date: null,
                end_date: null,
                loading: false
            }
        },

        watch: {
            name(newVal, oldVal) {
                if(this.slugify(oldVal) === this.slug) {
                    this.slug = this.slugify(newVal);
                }
            }
        },

        methods: {
            createNewActivity(data) {
                this.loading = true;
                this.$api.activity().create({
                    name: data.name,
                    description: data.description,
                    slug: data.slug,
                    type: data.type,
                    activity_for: data.activity_for,
                    for_logic: data.for_logic,
                    admin_logic: data.admin_logic,
                    start_date: data.range?.lower,
                    end_date: data.range?.upper
                }, 'creating-activity')
                    .then(response => {
                        this.$notify.success('Activity created');
                        window.location.href = '/activity/' + response.data.id;
                    })
                    .catch(error => this.$notify.alert('Could not create activity: ' + error.message))
            }
        },


    }
</script>

<style scoped>

</style>
