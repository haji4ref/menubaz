<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
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

        <v-container fluid v-else>
            <v-row
                    no-gutters
            >
                <v-col

                        md="6"
                >
                    <v-text-field class="mx-2" v-model="form.name"
                                  placeholder="نام"></v-text-field>
                </v-col>

                <v-col cols="12"
                       md="6">
                    <v-text-field type="number" class="mx-2" v-model="form.price"
                                  placeholder="قیمت به تومان"></v-text-field>
                </v-col>

                <v-col cols="12"
                       md="6">
                    <v-text-field class="mx-2" v-model="form.bolded_description"
                                  placeholder="توضیحات مهم"></v-text-field>
                </v-col>

                <v-col cols="12"
                       md="6">
                    <div class="mr-2 mt-2 d-flex justify-start">
                        <div>
                            عکس غذا
                            <vue-upload-multiple-image
                                    :multiple="false"
                                    popupText=""
                                    style="direction: ltr"
                                    :data-images="form.image"
                                    dragText="می تونید عکستونو درگ کنید"
                                    browseText="می تونید عکستونو انتخاب کنید"
                                    primaryText=""
                                    markIsPrimaryText=""
                                    @upload-success="imageUploaded"
                                    @edit-image="imageUploaded"
                            ></vue-upload-multiple-image>
                        </div>
                    </div>
                </v-col>

                <v-col cols="12">
                    <v-textarea class="mr-3" v-model="form.description"
                                placeholder="توضیحات"></v-textarea>
                </v-col>

                <v-col cols="12" class="mb-3">
                    <v-btn class="mr-3" @click="submit" color="success">
                        {{createOrEditLabel}}
                    </v-btn>

                    <v-btn v-if="editItem" @click="resetFields" class="mr-3" color="error">انصراف</v-btn>
                </v-col>
            </v-row>

            <v-data-table
                    dir="rtl"
                    no-data-text="چیزی وجود ندارد:("
                    :headers="headers"
                    :items="items"
                    :items-per-page="5"
                    class="elevation-1"
            >
                <template v-slot:item.action="{ item }">
                    <div class="d-flex">
                        <v-btn outlined color="blue" small @click="goToEdit(item)">
                            ویرایش
                        </v-btn>


                        <v-badge
                                class="mx-3"
                                color="red"
                                overlap
                                right
                        >
                            <template v-slot:badge>
                                <span v-if="hasUnSeen(item)">
                                    {{unSeenLength(item)}}
                                </span>
                            </template>
                            <v-btn outlined color="orange" small @click="showDialog(item)">
                                نظرات
                            </v-btn>
                        </v-badge>

                        <v-btn outlined color="red" small @click="remove(item)">
                            حذف
                        </v-btn>

                    </div>

                </template>
            </v-data-table>
        </v-container>
        <comments-dialog v-model="showCommentsDialog" :comments="comments"/>

    </div>
</template>

<script>
  import VueUploadMultipleImage from 'vue-upload-multiple-image'
  import VButton from '../../../../components/global/Button'
  import CommentsDialog from '../../../../components/CommentsDialog'
  import Snack from '../../../../components/utils/snack'

  export default {
    components: {
      Snack,
      CommentsDialog,
      VButton,
      VueUploadMultipleImage,
    },
    layout: 'dashboard',
    name: 'index',
    computed: {
      createOrEditLabel () {
        return this.editItem ? ` ویرایش ${this.editItem.name}` : 'اضافه کردن غذا'
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
      async goToEdit (item) {
        try {
          let gallery = await this.$axios.get(`gallery/${item.gallery_id}`)
          this.form.image.push({
            path: gallery.data.publicUrl,
          })
        } catch (e) {
          console.log(e)
        } finally {
          this.api = `menu_item/${item.id}`
          this.editItem = item
          this.form.name = item.name
          this.form.price = item.price
          this.form.bolded_description = item.bolded_description
          this.form.description = item.description
        }

      },
      remove (item) {
        this.$axios
          .delete(`menu_item/${item.id}`)
          .then(res => {
            this.items = res.data
            this.resetFields()
            this.showSuccess('با موفقیت پاک شد.')
          })
      },
      showDialog (item) {
        this.showCommentsDialog = true
        this.comments = item.comments
      },
      hasUnSeen (item) {
        return item.comments.find(e => e.seen === false)
      },
      unSeenLength (item) {
        return item.comments.filter(e => !e.seen).length
      },
      submit () {
        this.formData = this.convertToFormData(this.form, this.formData)
        this.$axios
          .post(this.api, this.formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(res => {
            this.items = res.data
            this.resetFields()
            this.showSuccess('با موفقیت ساخته شد.')
          })
      },
      resetFields () {
        this.api = `menu_categories/${this.$route.params.id}/item`
        this.formData = null
        this.editItem = null
        this.form = {
          name: '',
          price: '',
          bolded_description: '',
          description: '',
          image: []
        }
      },
      imageUploaded (formData) {
        this.formData = formData
      },
      convertToFormData (form, form_data) {
        let tmp_form_data = form_data || new FormData()

        if (tmp_form_data.has('file')) {
          tmp_form_data.set('image', form_data.get('file'))
          tmp_form_data.delete('file')
        }

        Object
          .keys(form)
          .filter(e => e !== 'image')
          .forEach(e => {
            if (form[e]) {
              tmp_form_data.append(e, form[e])
            }
          })

        return tmp_form_data
      }
    },
    data () {
      return {
        snackbar: {
          show: false,
          color: 'green',
          text: '',
          timeout: 2000
        },
        items: [],
        comments: [],
        showCommentsDialog: false,
        loading: true,
        formData: null,
        headers: [
          { text: 'نام', value: 'name' },
          { text: 'عملیات', value: 'action', sortable: false },
        ],
        editItem: null,
        api: `menu_categories/${this.$route.params.id}/item`,
        form: {
          name: '',
          price: '',
          bolded_description: '',
          description: '',
          image: []
        }
      }
    },
    created () {
      this.$axios(`menu_categories/${this.$route.params.id}/items`)
        .then((res) => {
          this.items = res.data
          this.loading = false
        })
    }
  }
</script>

<style scoped>

</style>
