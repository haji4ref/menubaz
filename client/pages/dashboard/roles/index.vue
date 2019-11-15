<template>
    <div>

        <v-data-table
                dir="rtl"
                :headers="headers"
                :items="roles"
                :items-per-page="5"
                class="elevation-1"
        ></v-data-table>


        <v-btn class="mt-3" color="success">
            <nuxt-link class="text-decorate-none white--text" :to="{name:'roles-create'}">
                ساخت نقش جدید
                <v-icon>mdi-plus</v-icon>
            </nuxt-link>
        </v-btn>

    </div>
</template>

<script>
  export default {
    layout: 'dashboard',
    data () {
      return {
        headers: [
          { text: '#', value: 'id' },
          { text: 'نقش', value: 'name' },
        ]
      }
    },
    methods: {},
    async asyncData ({ $axios }) {
      let roles = await $axios('api/roles')

      return { roles: roles.data }
    }
  }
</script>

<style>

</style>
