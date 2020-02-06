<template>
    <v-card class="elevation-12">
        <v-toolbar color="primary" dark flat>
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
            <v-spacer />
            <v-btn color="primary" @click="submit">تایید</v-btn>
        </v-card-actions>

        <snack v-model="showSnack" color="red" :text="snackMsg" />
    </v-card>
</template>

<script>
import snack from "~/components/utils/snack";
export default {
    data() {
        return {
            form: {
                verification_code: ""
            },
            showSnack: false,
            snackMsg: ""
        };
    },
    components: {
        snack
    },
    layout: "center",
    asyncData({ store, redirect }) {
        if (store.state.auth.user.verified) {
            return redirect("/dashboard");
        }
    },
    methods: {
        async submit() {
            try {
                await this.$axios.post("auth/verify", this.convertedForm);
                await this.$auth.fetchUser();
                this.$router.push("/dashboard");
            } catch (e) {
                if (e.response) {
                    this.showSnack = true;
                    this.snackMsg = e.response.data.message;
                }
            }
        },
        convertToEnglish(str) {
            return str.replace(/([۰-۹])/g, function(token) {
                return String.fromCharCode(token.charCodeAt(0) - 1728);
            });
        }
    },
    computed: {
        convertedForm() {
            let form = {};
            Object.keys(this.form).forEach(e => {
                form[e] = this.convertToEnglish(this.form[e]);
            });
            return form;
        }
    }
};
</script>

<style>
</style>
