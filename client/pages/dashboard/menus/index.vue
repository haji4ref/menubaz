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
                    <v-btn outlined color="blue" small @click="goToFoods(item)">
                        غذاها
                    </v-btn>

                    <v-btn outlined color="orange" small @click="goToEdit(item)">
                        ویرایش
                    </v-btn>

                    <v-btn outlined color="red" small
                           @click="(deleteConfirmShow = ! deleteConfirmShow) && (selectedForDelete = item)">
                        حذف
                    </v-btn>
                </template>
            </v-data-table>
        </div>
        <v-dialog
                v-model="deleteConfirmShow"
                max-width="500px"
        >
            <v-card class="py-6">
                <div class="text-center mb-6">
                    از پاک کردن این دسته بندی اطمینان داری؟
                </div>

                <div class="flex text-center">
                    <v-btn style="width: 45%" class="white--text mx-2" color="green" @click="deleteCategory">آره</v-btn>
                    <v-btn style="width: 45%" class="white--text mx-2" color="red"
                           @click="deleteConfirmShow = !deleteConfirmShow">
                        نه
                    </v-btn>
                </div>

            </v-card>

        </v-dialog>
    </div>
</template>

<script>
  export default {
    name: 'index',
    layout: 'dashboard',
    data () {
      return {
        deleteConfirmShow: false,
        selectedForDelete: null,
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
      async deleteCategory () {
        await this.$axios.delete(`menu_categories/${this.selectedForDelete.id}`)
        await this.getCategories()
        this.deleteConfirmShow = !this.deleteConfirmShow
      },
      async addCategory () {
        let category = await this.$axios.post(`menu/${this.menu.id}/categories`, { name: this.categoryName })
        this.categories.push(category.data)
        this.categoryName = ''
      },
      goToFoods (item) {
        this.$router.push(`/dashboard/menu_categories/${item.id}/foods`)
      },
      async getCategories () {
        this.loading = true
        let categories = await this.$axios(`menu/${this.menu.id}/categories`)
        this.categories = categories.data
        this.loading = false
      }
    },
    async created () {
      let menu = await this.$axios('menu')
      this.menu = menu.data
      await this.getCategories()
    }
  }
</script>

<style scoped>

</style>
