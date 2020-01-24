<template>
    <v-card class="elevation-12">
        <v-toolbar
                color="success"
                dark
                flat
        >
            <v-toolbar-title>عضویت</v-toolbar-title>

        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                        v-model="form.name"
                        label="نام و نام خانوادگی"
                        name="login"
                        prepend-icon="mdi-face"
                        type="text"></v-text-field>

                <v-text-field
                        v-model="form.mobile"
                        id="password"
                        label="شماره موبایل"
                        name="password"
                        prepend-icon="mdi-phone"
                        type="text"></v-text-field>

                <v-text-field
                        v-model="form.password"
                        id="password"
                        label="رمزعبور"
                        name="password"
                        prepend-icon="mdi-lock"
                        type="password"></v-text-field>

                <v-text-field
                        v-model="form.password_confirmation"
                        id="password"
                        label="تکرار رمز عبور"
                        name="password"
                        prepend-icon="fa-lock"
                        type="password"></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="primary" @click="submit">ثبت نام</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>

  export default {
    props: {
      source: String,
    },
    layout: 'center',
    methods: {
      submit () {
        if (this.form.password === this.form.password_confirmation) {
          this.$axios.post('register', this.form).then((res) => {
            console.log(res)
          })
        }
      }
    },
    data () {
      return {
        form: {
          name: '',
          mobile: '',
          password: '',
          password_confirmation: '',
        }
      }
    }
  }
</script>
