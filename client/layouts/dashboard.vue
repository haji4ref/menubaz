<template>
    <v-app id="inspire">
        <v-navigation-drawer
                v-model="drawer"
                app
                right
        >
            <v-list dense>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>fa-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>خانه</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>fa-robot</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>ساخت ربات</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
                app
                color="#0088cc"
                dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
                <v-icon>fa-bars</v-icon>
            </v-app-bar-nav-icon>
            <v-toolbar-title>داشبورد</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <v-container
                    class="fill-height"
                    fluid
            >
                <v-row
                        align="center"
                        justify="center"
                >
                    <v-col class="text-center">
                        <nuxt/>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer
                color="#0088cc"
                app
        >
            <span class="white--text ">توسعه داده شده با امید و 💖</span>
        </v-footer>
    </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    middleware: 'verified',
    data: () => ({
      drawer: null,
    }),
  }
</script>
