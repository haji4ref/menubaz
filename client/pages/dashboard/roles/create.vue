<template>
    <v-card class="pa-3">
        <div class="title">
            <div class="font-iran">
                ساخت نقش جدید
            </div>

            <v-divider/>

            <v-form>
                <v-row>
                    <v-col cols="3">
                        <v-text-field
                                label="نام"
                                required
                        ></v-text-field>
                    </v-col>
                </v-row>

            </v-form>

        </div>
    </v-card>
</template>

<script>
  export default {
    layout: 'dashboard',
    name: 'create-role'
  }
</script>

<style scoped>

</style>
