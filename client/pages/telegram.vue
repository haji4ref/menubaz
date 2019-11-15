<template>
<div>
  <h1>telegram</h1>
</div>
</template>

<script>
    export default {
        name: "telegram",
        auth: false,

        created() {
            this.$axios.get('/setwebhook').then(res => {
                console.log(res);
            })
        }
    }
</script>

<style scoped>

</style>
