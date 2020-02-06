<template>
    <v-card class="elevation-12">
        <v-toolbar color="primary" dark flat>
            <v-toolbar-title>ورود</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                    v-model="form.mobile"
                    label="شماره موبایل"
                    name="password"
                    prepend-icon="mdi-face"
                    type="text"
                />

                <v-text-field
                    v-model="form.password"
                    label="رمزعبور"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                />
            </v-form>
        </v-card-text>
        <v-container>
            <v-row class="justify-center">
                <v-col cols="6">
                    <v-btn style="width:100%" color="success" @click="submit">ورود</v-btn>
                </v-col>
            </v-row>

            <v-row class="justify-center">
                <v-btn
                    color="info"
                    @click="$router.push('/register')"
                    text
                    class="caption"
                >عضو نیستم</v-btn>
                <v-btn
                    color="warning"
                    @click="$router.push('/register')"
                    text
                    class="caption"
                >رمز عبورم را فراموش کردم</v-btn>
            </v-row>
        </v-container>

        <snack v-model="showSnack" color="red" text="شماره موبایل یا رمز عبور اشتباه است."></snack>
    </v-card>
</template>

<script>
import snack from "~/components/utils/snack.vue";
export default {
    components: {
        snack
    },
    data() {
        return {
            form: {
                mobile: "",
                password: ""
            },
            showSnack: false
        };
    },
    layout: "center",
    methods: {
        convertToEnglish(str) {
            return str.replace(/([۰-۹])/g, function(token) {
                return String.fromCharCode(token.charCodeAt(0) - 1728);
            });
        },
        async submit() {
            try {
                let result = await this.$auth.login({
                    data: this.convertedForm
                });
                this.$router.push("/dashboard");
            } catch (e) {
                this.showSnack = true;
            }
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
