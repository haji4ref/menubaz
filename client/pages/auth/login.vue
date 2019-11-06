<template>
    <v-card class="elevation-12">
        <v-toolbar
                color="primary"
                dark
                flat
        >
            <v-toolbar-title>ورود</v-toolbar-title>

        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                        v-model="form.mobile"
                        label="شماره موبایل"
                        name="password"
                        prepend-icon="fa-mobile"
                        type="text"
                />

                <v-text-field
                        v-model="form.password"
                        label="رمزعبور"
                        name="password"
                        prepend-icon="fa-lock"
                        type="password"
                />
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="primary" @click="submit">ورود</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
  export default {
    data () {
      return {
        form: {
          mobile: '',
          password: '',
        }
      }
    },
    layout: 'center',
    methods: {
      async submit () {
        try {
          let result = await this.$auth.login({
            data: this.form
          })
          this.$router.push('/dashboard')
        } catch (e) {

        }

      }
    },
    created () {

    }
  }
</script>

<style>

</style>
