<template>
    <v-app id="inspire">
        <v-content>
            <v-container
                    class="fill-height"
                    fluid
            >
                <v-row
                        align="center"
                        justify="center"
                >
                    <v-col
                            class="mr-5"
                            cols="12"
                            sm="8"
                            md="4">
                        <nuxt/>
                    </v-col>

                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
  export default {
    name: 'center'
  }
</script>

<style scoped>

</style>
