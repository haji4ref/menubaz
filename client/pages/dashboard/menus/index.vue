<template>
    <div>
        <v-progress-circular
                v-if="loading"
                indeterminate
                color="primary"
        ></v-progress-circular>

        <div v-else>

            <div class="d-flex align-center">
                <v-text-field @keydown.enter="addCategory" v-model="categoryName"
                              placeholder="دسته بندی"></v-text-field>
                <v-btn @click="addCategory" class="mr-3" color="success">اضافه کردن دسته بندی</v-btn>
            </div>

            <v-data-table
                    dir="rtl"
                    no-data-text="چیزی وجود ندارد:("
                    :headers="headers"
                    :items="categories"
                    :items-per-page="5"
                    class="elevation-1"
            >
                <template v-slot:item.action="{ item }">
                    <v-icon
                            small
                            color="primary"
                            class="mr-2"
                            @click="goToFoods(item)"
                    >
                        mdi-food
                    </v-icon>
                </template>
            </v-data-table>
        </div>

    </div>
</template>

<script>
  export default {
    name: 'index',
    layout: 'dashboard',
    data () {
      return {
        menu: null,
        loading: true,
        headers: [
          { text: 'نام', value: 'name' },
          { text: 'عملیات', value: 'action', sortable: false },
        ],
        categories: [],
        categoryName: '',
      }
    },
    methods: {
      async addCategory () {
        let category = await this.$axios.post(`menu/${this.menu.id}/categories`, { name: this.categoryName })
        this.categories.push(category.data)
        this.categoryName = ''
      },
      goToFoods (item) {
        this.$router.push(`/dashboard/menu_categories/${item.id}/foods`)
      }
    },
    async created () {
      let menu = await this.$axios('menu')
      this.menu = menu.data
      let categories = await this.$axios(`menu/${this.menu.id}/categories`)
      this.categories = categories.data
      this.loading = false

    }
  }
</script>

<style scoped>

</style>
