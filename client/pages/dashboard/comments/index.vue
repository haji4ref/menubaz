<template>
    <div>
        <v-progress-circular
                v-if="loading"
                indeterminate
                color="primary"
        ></v-progress-circular>

        <div v-else>

            <v-data-table
                    v-model="selected"
                    dir="rtl"
                    show-select
                    no-data-text="چیزی وجود ندارد:("
                    :headers="headers"
                    :items="comments"
                    :items-per-page="5"
                    class="elevation-1"
                    @item-selected="commentSeen"
            >

            </v-data-table>
        </div>

    </div>
</template>

<script>
  import moment from 'moment-jalaali'

  export default {
    layout: 'dashboard',
    name: 'index',
    methods: {
      commentSeen ({ item, value }) {
        this.$axios.post(`comment/${item.id}/seen`, { seen: value })
      }
    },
    async created () {
      let menu = await this.$axios('user/comments')
      this.comments = menu.data
      this.comments.forEach(e => {
        e.created_at = moment(e.created_at).format('HH:mm - jYYYY/jMM/jDD')
      })
      this.selected = this.comments.filter(e => e.seen)
      this.loading = false

    },
    data () {
      return {
        selected: [],
        loading: true,
        headers: [
          { text: 'متن نظر', value: 'body' },
          { text: 'عملیات', value: 'action', sortable: false },
          { text: 'تاریخ ثبت', value: 'created_at' }
        ],
        comments: [],
      }
    }
  }
</script>

<style scoped>

</style>
