<template>
    <v-card class="elevation-12">
        <v-toolbar
                color="primary"
                dark
                flat
        >
            <v-toolbar-title>تایید هویت</v-toolbar-title>

        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                        v-model="form.verification_code"
                        label="کد تایید هویت"
                        name="password"
                        prepend-icon="fa-num"
                        type="text"
                />

            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="primary" @click="submit">تایید</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
  export default {
    data () {
      return {
        form: {
          verification_code: '',
        }
      }
    },
    layout: 'center',
    asyncData ({ store, redirect }) {
      if (store.state.auth.user.verified) {
        return redirect('/dashboard')
      }
    },
    methods: {
      async submit () {
        try {
          await this.$axios.post('auth/verify', this.form)
          await this.$auth.fetchUser()
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
