<template>
    <div>
        <snack v-model="snackbar.show"
               :color="snackbar.color"
               :text="snackbar.text"
               :timeout="snackbar.timeout"/>


        <v-container fluid class="grey lighten-5">
            <v-row
                    no-gutters
            >
                <v-col cols="6">
                    <div class="mb-2">متن پیام درباره ما</div>
                    <v-textarea
                            solo
                            v-model="contact_us_msg"
                            label="درباره ما"
                    ></v-textarea>
                </v-col>
            </v-row>
        </v-container>

        <v-btn color="success" @click="submit">ثبت</v-btn>
    </div>
</template>

<script>
  import Snack from '../../../components/utils/snack'

  export default {
    components: { Snack },
    layout: 'dashboard',
    data () {
      return {
        contact_us_msg: '',
        snackbar: {
          show: false,
          color: 'green',
          text: '',
          timeout: 2000
        }
      }
    },
    methods: {
      submit () {
        this
          .$axios
          .post(`bot/${this.$route.params.id}`, { contact_us_msg: this.contact_us_msg })
          .then(res => {
            this.snackbar = { show: true, color: 'green', text: 'با موفقت ویرایش شد.', timeout: 2000 }
          })
          .catch(e => {
            console.error(e)
            this.snackbar = { show: true, color: 'red', text: 'مشکلی در روند ویرایش پیش آمده است.', timeout: 2000 }
          })

      }
    },
    created () {
      this
        .$axios
        .get(`bot/${this.$route.params.id}`)
        .then((res) => {
          this.contact_us_msg = res.data.contact_us_msg
        })
    }
  }
</script>

<style>

</style>
