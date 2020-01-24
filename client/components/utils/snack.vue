<template>
    <v-snackbar
            v-model="snackbar"
            :timeout="timeout"
            bottom
            left
            :color="color"
    >
        {{text}}
        <v-btn
                text
                @click="snackbar = false"
        >
            <v-icon>mdi-close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>
  export default {
    props: ['value', 'color', 'timeout', 'text'],
    name: 'snack',
    computed: {
      snackbar: {
        get () {
          return this.value
        },
        set (v) {
          this.$emit('input', v)
        }
      }
    }
  }
</script>

<style scoped>

</style>
