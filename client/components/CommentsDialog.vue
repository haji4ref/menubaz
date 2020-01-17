<template>
    <v-dialog
            v-model="myValue"
            max-width="500px"
    >
        <v-card style="padding: 10px">
            <v-card-title>
                نظرات
            </v-card-title>

            <v-card-text>
                <v-card v-for="(comment,index) in comments" class="blue-grey lighten-5 mb-4"
                        style="padding: 10px;"
                        :elevation="1">
                    <div class="d-flex justify-space-between">
                        <span>{{comment.body}}</span>
                        <span>
                            <v-checkbox
                                    style="margin: 0;padding: 0"
                                    v-model="comment.seen"
                                    @change="(value)=>updateSeen(comment,value)"
                                    label="دیده شده"
                            ></v-checkbox>
                        </span>

                    </div>
                </v-card>
            </v-card-text>

            <v-card-actions>
                <v-btn
                        color="primary"
                        outlined
                        @click="myValue = false"
                >
                    باشه
                </v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>
</template>

<script>
  export default {
    name: 'CommentsDialog',
    props: ['value', 'comments'],
    methods: {
      updateSeen (comment, value) {
        console.log(value)
        this.$axios.post(`comment/${comment.id}/seen`, { seen: value })
      }
    },
    computed: {
      myValue: {
        get () {
          return this.value
        },
        set (v) {
          this.$emit('input', v)
        }
      },

    }
  }
</script>

<style scoped>

</style>
