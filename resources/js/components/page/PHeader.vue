<template>
    <div>
        <v-navigation-drawer
            app
            :width="drawerWidth"
            clipped
            :permanent="showDrawer"
            :mini-variant.sync="isMini"
            v-model="showDrawer"
            v-if="isLoggedIn">

            <template v-slot:prepend>
                <v-list-item>
                    <v-list-item-avatar v-if="!isMini">
                        <img src="https://randomuser.me/api/portraits/men/81.jpg">
                    </v-list-item-avatar>

                    <v-list-item-title v-if="!isMini">Welcome{{ (firstName === '' ? '' : ', ' + firstName)}}</v-list-item-title>

                    <v-btn
                        icon
                        @click.stop="toggleMini"
                    >
                        <v-icon v-if="isMini">mdi-chevron-right</v-icon>
                        <v-icon v-else>mdi-chevron-left</v-icon>
                    </v-btn>
                </v-list-item>
            </template>

            <v-divider></v-divider>

            <p-nav-drawer-portal>

            </p-nav-drawer-portal>
<!--            <component :is="drawerTag"></component>-->

            <template v-slot:append>
                <div class="pa-2">
                    <v-switch v-if="!isMini" v-model="darkMode" inset :label="'Dark Mode ' + (darkMode ? 'On' : 'Off')"></v-switch>
                    <v-form action="/logout" method="POST">
                        <input type="hidden" name="_token" :value="csrf" />
                        <v-btn type="submit" text v-if="!isMini">
                            Sign out <v-icon>mdi-logout</v-icon>
                        </v-btn>
                        <v-btn type="submit" icon v-else>
                            <v-icon>mdi-logout</v-icon>
                        </v-btn>
                    </v-form>
                </div>
            </template>

        </v-navigation-drawer>

        <v-app-bar app clipped-left color="primary">

            <v-app-bar-nav-icon @click.stop="toggleDrawer" v-if="isLoggedIn && tinyScreen"></v-app-bar-nav-icon>

            <v-spacer></v-spacer>

            <v-toolbar-title>{{ title }}</v-toolbar-title>

            <v-spacer></v-spacer>

            <span v-if="isLoggedIn">
                <v-badge
                    content="3"
                    overlap
                >
                    <v-btn small icon>
                        <v-icon>mdi-bell</v-icon>
                    </v-btn>
                </v-badge>
            </span>

<!--            <v-menu-->
<!--                left-->
<!--                bottom-->
<!--            >-->
<!--                <template v-slot:activator="{ on, attrs }">-->
<!--                    <v-btn-->
<!--                        icon-->
<!--                        v-bind="attrs"-->
<!--                        v-on="on"-->
<!--                    >-->
<!--                        <v-icon>mdi-dots-vertical</v-icon>-->
<!--                    </v-btn>-->
<!--                </template>-->

<!--                <v-list>-->

<!--                </v-list>-->
<!--            </v-menu>-->
        </v-app-bar>
    </div>
</template>

<script>
import csrf from 'Mixins/csrf';
import userpreferences from 'Mixins/userpreferences';

export default {
    name: "PHeader",
    mixins: [csrf, userpreferences],
    props: {
        title: {
            required: false,
            type: String,
            default: 'Portal'
        },
        isLoggedIn: {
            required: false,
            type: Boolean,
            default: false
        },
        drawerTag: {
            required: true,
            type: String
        },
        firstName: {
            required: false,
            type: String,
            default: ''
        }
    },
    created() {
        this.isMini = this.smallScreen;
    },
    data() {
        return {
            isMini: false,
            showDrawer: true,
        }
    },
    methods: {
        toggleMini() {
            this.isMini = !this.isMini;
        },
        toggleDrawer() {
            this.showDrawer = !this.showDrawer;
            if(this.showDrawer) {
                this.isMini = false;
            }
        },
    },
    computed: {
        smallScreen() {
            return this.$vuetify.breakpoint.smOnly;
        },
        tinyScreen() {
            return this.$vuetify.breakpoint.xsOnly;
        },
        darkMode: {
            get() {
                return this.$vuetify.theme.dark;
            },
            set(val) {
                this.$vuetify.theme.dark = val;
                this.setUserPreference('dark-mode', (val ? 'true' : 'false'));
            }
        },
        drawerWidth() {
            if(this.$vuetify.breakpoint.xlOnly) {
                return '20%';
            } else if(this.$vuetify.breakpoint.lgAndUp) {
                return '25%';
            } else if(this.$vuetify.breakpoint.mdAndUp) {
                return '35%';
            }
            else if(this.$vuetify.breakpoint.smAndUp) {
                return '45%';
            }
            return '90%'
        }
    }
}
</script>

<style scoped>

</style>
