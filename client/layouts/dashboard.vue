<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app right>
            <v-list dense>
                <!--<v-list-item link>-->
                <!--<v-list-item-action>-->
                <!--<v-icon color="success">mdi-home</v-icon>-->
                <!--</v-list-item-action>-->
                <!--<v-list-item-content>-->
                <!--<nuxt-link class="text-decorate-none" to="/dashboard/roles">-->
                <!--<v-list-item-title>-->
                <!--نقش ها-->
                <!--</v-list-item-title>-->
                <!--</nuxt-link>-->
                <!--</v-list-item-content>-->
                <!--</v-list-item>-->

                <v-list-item link>
                    <v-list-item-action>
                        <v-icon color="primary">mdi-robot</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <nuxt-link class="text-decorate-none" to="/dashboard/bots">
                            <v-list-item-title>
                                ربات ها
                            </v-list-item-title>
                        </nuxt-link>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-action>
                        <v-icon color="error">mdi-file</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <nuxt-link class="text-decorate-none" to="/dashboard/menus">
                            <v-list-item-title>
                                مدیریت منو
                            </v-list-item-title>
                        </nuxt-link>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-action>
                        <v-icon color="warning">mdi-comment</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <nuxt-link class="text-decorate-none" to="/dashboard/comments">
                            <v-list-item-title>
                                <div class="d-flex justify-space-between">
                                    <div>مدیریت نظرات</div>
                                    <div v-if="unseen > 0" class="white--text red text-center pt-1"
                                         style="border-radius: 50%;width: 20px;height: 20px">{{unseen}}
                                    </div>
                                </div>
                            </v-list-item-title>
                        </nuxt-link>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="#0088cc" dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title class="d-flex justify-space-between flex-grow-1 align-center">
                <div>داشبورد</div>
                <div class="d-flex align-center">
                    <div class="subtitle-1 mx-2">{{$auth.user.name}}</div>
                    <v-btn color="red lighten-1" @click="logout">خروج</v-btn>
                </div>
            </v-toolbar-title>
        </v-app-bar>

        <v-content>
            <v-container class="fill-height align-start" fluid>
                <v-row justify="center">
                    <v-col>
                        <nuxt/>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer color="#0088cc" app>
            <span class="white--text">توسعه داده شده با امید و 💖</span>
        </v-footer>
    </v-app>
</template>

<script>
  export default {
    props: {
      source: String
    },
    middleware: ['auth', 'verified'],
    data: () => ({
      drawer: null,
      unseen: 0
    }),
    methods: {
      logout () {
        this.$auth.logout()
      }
    },
    created () {
      this.$axios('user/comments/unseen').then(res => {
        this.unseen = res.data
      })
    }
  }
</script>
