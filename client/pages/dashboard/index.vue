<template>
    <div>
        <v-btn @click="logout">logout</v-btn>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    layout: "dashboard",
    methods: {
        logout() {
            this.$auth.logout();
        }
    },
    created() {}
};
</script>

<style>
</style>
