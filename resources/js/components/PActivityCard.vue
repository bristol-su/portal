<template>
    <v-card
        class="mx-auto"
        max-width="344"
    >
        <v-img
            src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
            height="200px"
        ></v-img>

        <v-card-title>
            {{activity.name}}
            <span class="px-2"><v-icon :color="activityPercentageColour" v-if="evaluation.complete">mdi-check-circle</v-icon></span>

        </v-card-title>

        <v-card-subtitle>
            {{activity.description}}
        </v-card-subtitle>

        <v-card-text>
            <v-skeleton-loader
                :loading="evaluationLoading"
                type="text"
                transition="scale-transition">

            <v-progress-linear
                v-model="evaluation.percentage"
                :color="activityPercentageColour"
                height="25"
            >
                <template v-slot="{ value }">
                    <strong>{{ Math.ceil(value) }}%</strong>
                </template>
            </v-progress-linear>
            </v-skeleton-loader>

        </v-card-text>

        <v-card-actions>
            <a :href="activityUrl">
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
    name: "PActivityCard",

    props: {
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
            ],
            evaluation: {
                percentage: 0,
                complete: false
            },
            evaluationLoading: false
        }
    },

    created() {
        this.loadEvaluation();
    },
    methods: {
        loadEvaluation() {
            this.evaluationLoading = true;
            this.getEvaluation()
                .then(response => this.evaluation = response.data)
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.evaluationLoading = false)
        },
        getEvaluation() {
            if (this.admin) {
                if (this.hasRole) {
                    return this.$api.activityEvaluation().forAdminRole(this.userId, this.groupId, this.roleId, this.activity.id);
                }
                if (this.hasGroup) {
                    return this.$api.activityEvaluation().forAdminGroup(this.userId, this.groupId, this.activity.id);
                }
                return this.$api.activityEvaluation().forAdminUser(this.userId, this.activity.id);
            }
            if (this.hasRole) {
                return this.$api.activityEvaluation().forRole(this.userId, this.groupId, this.roleId, this.activity.id);
            }
            if (this.hasGroup) {
                return this.$api.activityEvaluation().forGroup(this.userId, this.groupId, this.activity.id);
            }
            return this.$api.activityEvaluation().forUser(this.userId, this.activity.id);
        }
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
        activityUrl() {
            return (this.admin?'/a/':'/p/')
            + this.activity.slug + '?' + Object.keys(this.query).map(key => key + '=' + this.query[key]).join('&')
        },
        activityPercentageColour() {
                for(let color of this.progressColor.slice()
                    .sort((a, b) => b.lower - a.lower)) {
                    if(color.lower <= this.evaluation.percentage) {
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
