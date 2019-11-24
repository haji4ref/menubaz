<template>
    <div>
        <v-text-field
                v-model="contact_us_msg"
                label="پیام ارتباط با ما"
        ></v-text-field>

        <v-btn color="success" @click="submit">ثبت</v-btn>
    </div>
</template>

<script>
  export default {
    layout: 'dashboard',
    data () {
      return {
        contact_us_msg: ''
      }
    },
    methods: {
      submit () {
        this
          .$axios
          .post(`bot/${this.$route.params.id}`, { contact_us_msg: this.contact_us_msg })

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
