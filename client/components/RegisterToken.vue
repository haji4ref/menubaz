<template>
    <div class="d-flex align-center">
        <v-text-field
                v-model="token"
                label="توکن ربات"
        ></v-text-field>

        <v-btn class="mr-3" color="success"  @click="register">اضافه کردن ربات جدید</v-btn>
    </div>
</template>

<script>
  export default {
    name: 'RegisterToken',
    data () {
      return {
        token: ''
      }
    },
    methods: {
      register () {
        this.$axios.post('bot/register', { token: this.token })
          .then(res => {
            this.$emit('created', res.data)
            this.token = ''
          })
      }
    }
  }
</script>

<style scoped>

</style>
