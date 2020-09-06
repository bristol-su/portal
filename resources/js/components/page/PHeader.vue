<template>
    <div>
<!--        <v-navigation-drawer-->
<!--            app-->
<!--            permanent-->
<!--            v-model="showDrawer">-->
<!---->
<!--        </v-navigation-drawer>-->

        <v-app-bar app color="primary">

<!--            <v-app-bar-nav-icon @click.stop="showDrawer = !showDrawer"></v-app-bar-nav-icon>-->

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
export default {
    name: "PHeader",
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
        }
    },
    data() {
        return {
            showDrawer: false,

        }
    }
}
</script>

<style scoped>

</style>
