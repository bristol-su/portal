    <v-app-bar app>


        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>{{ config('app.name', 'Committee Portal') }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-menu
            left
            bottom
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>

            <v-list>

            </v-list>
        </v-menu>
    </v-app-bar>
