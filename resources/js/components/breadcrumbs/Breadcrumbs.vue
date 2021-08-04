<template>
    <div>
        <b-breadcrumb>
            <a :href="backUrl" v-if="!hideBack">
                <b-button size="sm" pill variant="outline-secondary" aria-label="Back"><i class="fa fa-arrow-circle-left"></i> Back</b-button>
            </a>
            <b-breadcrumb-item href="/" style="padding-left: 1.5rem">
                <b-icon icon="house-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                Home
            </b-breadcrumb-item>
            <b-breadcrumb-item :href="activityUrl" v-if="inActivity" :active="inActivity && !inModuleInstance">{{activity.name}}</b-breadcrumb-item>
            <b-breadcrumb-item :href="moduleInstanceUrl" v-if="inModuleInstance" :active="inActivity && inModuleInstance">{{moduleInstance.name}}</b-breadcrumb-item>
        </b-breadcrumb>
    </div>
</template>

<script>
    import { BIcon, BIconHouseFill } from 'bootstrap-vue';
    export default {
        name: "Breadcrumbs",

        props: {
            admin: {
                type: Boolean,
                required: false,
                default: false
            },
            queryString: {
                type: String,
                required: true
            },
            previous: {
                type: String,
                default: null,
                required: false
            },
            hideBack: {
                type: Boolean,
                default: false,
                required: false
            }
        },

        components: {BIcon, BIconHouseFill},

        data() {
            return {}
        },

        methods: {
            makeUrl(path) {
                return '/' +
                    (this.admin ? 'a' : 'p') +
                    '/'
                    + path
                    + '?' + this.queryString;
            }
        },

        computed: {
            backUrl() {
                if(this.inModuleInstance) {
                    return this.activityUrl;
                } else if(this.inActivity) {
                    return '/';
                } else if(this.previous) {
                    return this.previous;
                }
                return document.referrer;
            },
            inActivity() {
                return Object.keys(this.activity).length > 0;
            },
            inModuleInstance() {
                return Object.keys(this.moduleInstance).length > 0;
            },
            moduleInstance() {
                if(window.portal.hasOwnProperty('module_instance') && window.portal.module_instance !== null) {
                    return window.portal.module_instance;
                }
                return {};
            },
            activity() {
                if(window.portal.hasOwnProperty('activity') && window.portal.activity !== null) {
                    return window.portal.activity;
                }
                return {};
            },
            activityUrl() {
                if(this.inActivity) {
                    return this.makeUrl(this.activity.slug);
                }
                return '#';
            },
            moduleInstanceUrl() {
                if(this.inModuleInstance) {
                    return this.makeUrl(this.activity.slug + '/' + this.moduleInstance.slug);
                }
                return '#';
            }
        }
    }
</script>

<style scoped>

</style>
