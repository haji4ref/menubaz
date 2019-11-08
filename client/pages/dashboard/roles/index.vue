<template>
    <div>
        <v-data-table
                dir="rtlg"
                :headers="headers"
                :items="roles"
                :items-per-page="5"
                class="elevation-1"
        ></v-data-table>
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
