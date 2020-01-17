<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <v-progress-circular
                v-if="loading"
                indeterminate
                color="primary"
        ></v-progress-circular>

        <div v-else>

            <div class="d-flex align-center">
                <v-text-field class="mx-2" v-model="form.name"
                              placeholder="نام"></v-text-field>

                <v-text-field type="number" class="mx-2" v-model="form.price"
                              placeholder="قیمت به ریال"></v-text-field>

                <v-text-field class="mx-2" v-model="form.bolded_description"
                              placeholder="توضیحات مهم"></v-text-field>


                <v-btn class="mr-3" @click="submit" color="success">اضافه کردن غذا</v-btn>
            </div>

            <div class="d-flex mb-3">
                <v-textarea class="mr-3" v-model="form.description"
                            placeholder="توضیحات"></v-textarea>

                <div class="mr-3">
                    عکس غذا
                    <vue-upload-multiple-image
                            :multiple="false"
                            popupText=""
                            style="direction: ltr"
                            :data-images="form.image"
                            dragText="می تونید عکستونو درگ کنید"
                            browseText="می تونید عکستونو انتخاب کنید"
                            primaryText="آپلود شد"
                            @upload-success="imageUploaded"
                    ></vue-upload-multiple-image>
                </div>

            </div>

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
                        <v-btn outlined color="blue" small>
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

                    </div>

                </template>
            </v-data-table>
        </div>
        <comments-dialog v-model="showCommentsDialog" :comments="comments"/>

    </div>
</template>

<script>
  import VueUploadMultipleImage from 'vue-upload-multiple-image'
  import VButton from '../../../../components/global/Button'
  import CommentsDialog from '../../../../components/CommentsDialog'

  export default {
    components: {
      CommentsDialog,
      VButton,
      VueUploadMultipleImage,
    },
    layout: 'dashboard',
    name: 'index',
    methods: {
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
          .post(`menu_categories/${this.$route.params.id}/item`, this.formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(res => {
            this.resetFields()
          })
      },
      resetFields () {
        this.formData = null
        this.form = {
          name: '',
          price: '',
          bolded_description: '',
          description: '',
          image: []
        }
      },
      imageUploaded (formData, index, fileList) {
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
        items: [],
        comments: [],
        showCommentsDialog: false,
        loading: true,
        formData: null,
        headers: [
          { text: 'نام', value: 'name' },
          { text: 'عملیات', value: 'action', sortable: false },
        ],
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
          console.log(res.data)
          this.items = res.data
          this.loading = false
        })
    }
  }
</script>

<style scoped>

</style>
