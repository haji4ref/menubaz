<template>
    <v-card class="elevation-12">
        <v-toolbar color="success" dark flat>
            <v-toolbar-title>عضویت</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                    v-model="form.full_name"
                    label="نام رستوران،کافه،فست فود و ..."
                    name="login"
                    prepend-icon="mdi-face"
                    :error="errorMessages.hasOwnProperty('full_name')"
                    :error-messages="errorMessages.full_name"
                    type="text"
                ></v-text-field>

                <v-text-field
                    v-model="form.mobile"
                    id="password"
                    label="شماره موبایل"
                    :error="errorMessages.hasOwnProperty('mobile')"
                    :error-messages="errorMessages.mobile"
                    name="password"
                    prepend-icon="mdi-phone"
                    type="text"
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    id="password"
                    label="رمزعبور"
                    name="password"
                    :error="errorMessages.hasOwnProperty('password')"
                    :error-messages="errorMessages.password"
                    prepend-icon="mdi-lock"
                    type="password"
                ></v-text-field>

                <v-text-field
                    v-model="form.password_confirmation"
                    id="password"
                    label="تکرار رمز عبور"
                    name="password"
                    :error="errorMessages.hasOwnProperty('password_confirmation')"
                    :error-messages="errorMessages.password_confirmation"
                    prepend-icon="fa-lock"
                    type="password"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-col cols="6" offset="3">
                <v-btn color="primary" @click="submit" style="width:100%">عضو میشم</v-btn>
            </v-col>
        </v-card-actions>
    </v-card>
</template>

<script>
import Vue from "vue";
export default {
    props: {
        source: String
    },
    layout: "center",
    methods: {
        convertToEnglish(str) {
            return str.replace(/([۰-۹])/g, function(token) {
                return String.fromCharCode(token.charCodeAt(0) - 1728);
            });
        },
        submit() {
            if (this.form.password === this.form.password_confirmation) {
                this.$axios
                    .post("register", this.convertedForm)
                    .then(res => {
                        return this.$auth.login({
                            data: this.convertedForm
                        });
                    })
                    .then(res => {
                        this.$router.push("/verification");
                    })
                    .catch(er => {
                        if (er.response && er.response.status === 422) {
                            let data = er.response.data;
                            Vue.set(this, "errorMessages", data.errors);
                        }
                    });
            } else {
                Vue.set(this, "errorMessages", {
                    password_confirmation: ["تکرار رمز عبور اشتباه است."]
                });
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
    },
    data() {
        return {
            form: {
                full_name: "",
                mobile: "",
                password: "",
                password_confirmation: ""
            },
            errorMessages: {}
        };
    }
};
</script>
