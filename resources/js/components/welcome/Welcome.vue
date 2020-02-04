<template>
    <div class="text-center">
        <div class="container">
            <div class="row ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1>{{title}}</h1>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <p class="lead text-muted">
                        {{subtitle}}
                    </p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row" v-if="registration" style="padding-top: 5%;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <registration-questions
                        :data-user="dataUser"
                        :attributes="attributes"
                        @input="form = $event"></registration-questions>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <b-button variant="secondary" size="lg" @click="saveAttributes">Get Started -></b-button>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import RegistrationQuestions from './RegistrationQuestions';
    export default {
        name: "Welcome",
        components: {RegistrationQuestions},
        props: {
            title: {
                required: false,
                type: String,
                default: 'Welcome to the portal!'
            },
            registration: {
                required: false,
                default: false,
                type: Boolean
            },
            dataUser: {
                required: true,
                type: Object
            },
            controlUser: {
                required: true,
                type: Object
            },
            subtitle: {
                required: false,
                type: String,
                default: 'Before we start, check our records are up to date!'
            },
            attributes: {
                required: false,
                type: Object,
                default: function() {
                    return {};
                }
            }
        },

        data() {
            return {
                form: {}
            }
        },

        methods: {
            saveAttributes() {
                this.$control.user().update(this.controlUser.id, this.form)
                    .then(response => {
                        window.location.href = '/p';
                    })
                    .catch(error => this.$notify.alert('Could not update your information'));
            }
        },

        computed: {}
    }
</script>

<style scoped>

</style>
