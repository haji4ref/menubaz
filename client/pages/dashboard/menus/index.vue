<template>
    <div>
        <snack v-model="snackbar.show"
               :color="snackbar.color"
               :text="snackbar.text"
               :timeout="snackbar.timeout"/>
        <v-progress-circular
                v-if="loading"
                indeterminate
                color="primary"
        ></v-progress-circular>

        <div v-else>

            <div class="d-flex align-center">
                <v-text-field @keydown.enter="editMode ? editCategory() : addCategory()" v-model="categoryName"
                              placeholder="دسته بندی"></v-text-field>
                <v-btn v-if="editMode" @click="editCategory" class="mr-3" color="success">ویرایش
                    {{selectedForEdit.name}}
                </v-btn>
                <v-btn v-if="editMode" @click="clearEdit" class="mr-3" color="error">انصراف</v-btn>
                <v-btn v-if="!editMode" @click="addCategory" class="mr-3" color="success">اضافه کردن دسته بندی</v-btn>

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
  import Snack from '../../../components/utils/snack'

  export default {
    name: 'index',
    components: { Snack },
    layout: 'dashboard',
    data () {
      return {
        snackbar: {
          show: false,
          color: 'green',
          text: '',
          timeout: 2000
        },
        deleteConfirmShow: false,
        selectedForDelete: null,
        selectedForEdit: null,
        menu: null,
        editMode: false,
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
      showSuccess (msg) {
        this.snackbar = {
          show: true,
          color: 'green',
          text: msg,
          timeout: 2000
        }
      },
      async deleteCategory () {
        await this.$axios.delete(`menu_categories/${this.selectedForDelete.id}`)
        await this.getCategories()
        this.deleteConfirmShow = !this.deleteConfirmShow
        this.showSuccess('با موفقیت پاک شد.')
      },
      async addCategory () {
        let category = await this.$axios.post(`menu/${this.menu.id}/categories`, { name: this.categoryName })
        this.categories.push(category.data)
        this.clearEdit()
        this.showSuccess('با موفقیت ساخته شد.')
      },
      async editCategory () {
        this.loading = true
        await this.$axios.put(`menu_categories/${this.selectedForEdit.id}`, { name: this.categoryName })
        this.getCategories()
        this.showSuccess('با موفقیت ویرایش شد')
      },
      goToFoods (item) {
        this.$router.push(`/dashboard/menu_categories/${item.id}/foods`)
      },
      goToEdit (item) {
        this.editMode = true
        this.categoryName = item.name
        this.selectedForEdit = item
      },
      clearEdit () {
        this.editMode = false
        this.categoryName = ''
        this.selectedForEdit = ''
      },
      async getCategories () {
        this.loading = true
        let categories = await this.$axios(`menu/${this.menu.id}/categories`)
        this.categories = categories.data
        this.loading = false
        this.clearEdit()
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
