<template>
    <div>
        <register-token @created="newBotAdded"/>

        <v-data-table
                dir="rtl"
                :headers="headers"
                :items="bots"
                :items-per-page="5"
                class="elevation-1"
        >
            <template v-slot:item.action="{ item }">
                <v-icon
                        small
                        color="primary"
                        class="mr-2"
                        @click="reload(item)"
                >
                    mdi-reload
                </v-icon>
                <v-icon
                        small
                        color="success"
                        class="mr-2"
                        @click="goToManage(item)"
                >
                    mdi-robot-industrial
                </v-icon>
            </template>
        </v-data-table>
    </div>


</template>

<script>
  import RegisterToken from '../../../components/RegisterToken'

  export default {
    name: 'index-bot',
    components: { RegisterToken },
    layout: 'dashboard',
    data () {
      return {
        bots: [],
        headers: [
          { text: '#', value: 'id' },
          { text: 'نام', value: 'name' },
          { text: 'توکن', value: 'token' },
          { text: 'عملیات', value: 'action', sortable: false },
        ]
      }
    },
    created () {
      this.$axios('bot')
        .then((res) => {
          this.bots = res.data
        })
    },
    methods:{
      reload(item){
        this.$axios.get(`bot/reload/${item.token}`);
      },
      newBotAdded(bots){
        this.bots = bots;
      },
      goToManage(item){
        console.log(item);
        this.$router.push(`/dashboard/bots/manage/${item.id}`);
      }
    }
  }
</script>

<style scoped>

</style>
