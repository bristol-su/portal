<template>
    <v-card
        class="mx-auto"
        max-width="344"
    >
        <v-img
            :src="moduleInstance.image_url"
            v-if="moduleInstance.image_url !== null"
            height="200px"
        ></v-img>

        <v-card-title>
            {{moduleInstance.name}}
            <span class="px-2"><v-icon :color="moduleInstancePercentageColour" v-if="moduleInstance.evaluation.complete">mdi-check-circle</v-icon></span>

        </v-card-title>

        <v-card-subtitle>
            {{moduleInstance.description}}
        </v-card-subtitle>

        <v-card-text v-if="!admin">
            <v-skeleton-loader
                :loading="false"
                type="text"
                transition="scale-transition">

            <v-progress-linear
                :value="moduleInstance.evaluation.percentage"
                :color="moduleInstancePercentageColour"
                height="25"
            >
                <template v-slot="{ value }">
                    <strong>{{ Math.ceil(value) }}%</strong>
                </template>
            </v-progress-linear>
            </v-skeleton-loader>

        </v-card-text>

        <v-card-actions>
            <a :href="moduleInstanceUrl">
                <v-btn color="primary">View</v-btn>
            </a>

            <v-spacer></v-spacer>

            <v-btn
                icon
                @click="expand = !expand"
            >
                <v-icon>{{ expand ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
        </v-card-actions>

        <v-card-text>

        </v-card-text>

        <v-expand-transition>
            <div v-show="expand">
                <v-divider></v-divider>

                <v-card-text>
                    I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                </v-card-text>
            </div>
        </v-expand-transition>
    </v-card>
</template>

<script>
export default {
    name: "PModuleInstanceCard",

    props: {
        moduleInstance: {
            type: Object,
            required: true
        },
        activity: {
            type: Object,
            required: true
        },
        admin: {
            required: true,
            type: Boolean
        },
        query: {
            required: false,
            type: Object,
            default: function() {
                return {};
            }
        }
    },

    data() {
        return {
            expand: false,
            progressColor: [
                {lower: 0, color: '#ff3200'},
                {lower: 20, color: '#ed7409'},
                {lower: 40, color: '#eda109'},
                {lower: 60, color: '#85a708'},
                {lower: 80, color: '#03880D'}
            ]
        }
    },

    created() {
    },
    methods: {
    },
    computed: {
        hasUser() {
            return window.portal.hasOwnProperty('user') && window.portal.user !== null && window.portal.user.hasOwnProperty('id');
        },
        hasGroup() {
            return window.portal.hasOwnProperty('group') && window.portal.group !== null && window.portal.group.hasOwnProperty('id');
        },
        hasRole() {
            return window.portal.hasOwnProperty('role') && window.portal.role !== null && window.portal.role.hasOwnProperty('id');
        },
        hasActivityInstance() {
            return window.portal.hasOwnProperty('activity_instance') && window.portal.activity_instance !== null && window.portal.activity_instance.hasOwnProperty('id');
        },
        userId() {
            if (this.hasUser) {
                return window.portal.user.id;
            }
            return null;
        },
        groupId() {
            if (this.hasGroup) {
                return window.portal.group.id;
            }
            return null;
        },
        roleId() {
            if (this.hasRole) {
                return window.portal.role.id;
            }
            return null;
        },
        activityInstanceId() {
            if (this.hasActivityInstance) {
                return window.portal.activity_instance.id;
            }
            return null;
        },
        moduleInstanceUrl() {
            let query = {};
            if(this.hasActivityInstance) {
                query.a = this.activityInstanceId;
            } if(this.hasUser) {
                query.u = this.userId;
            } if(this.hasGroup) {
                query.g = this.groupId;
            } if(this.hasRole) {
                query.r = this.roleId;
            }
            return (this.admin?'/a/':'/p/')
                + this.activity.slug + '/' + this.moduleInstance.slug + '?' + Object.keys(query).map(key => key + '=' + query[key]).join('&')
        },
        moduleInstancePercentageColour() {
                for(let color of this.progressColor.slice()
                    .sort((a, b) => b.lower - a.lower)) {
                    if(color.lower <= this.moduleInstance.evaluation.percentage) {
                        return color.color;
                    }
                }
            return '#b8b8b8'
        }
    }
}
</script>

<style scoped>

</style>
