<template>
  <v-container fluid>
      <h1 class="indigo--text text--lighten-2 text-center mb-8">Queries & Feedbacks</h1>
      <h4 v-if="noFeedbacks" class="grey--text text--darken-1 text-center mt-5">No Feedbacks Yet</h4>
    <v-row justify="center">
      <v-expansion-panels popout>
        <v-expansion-panel
          v-for="(feedback, i) in feedbacks"
          :key="i"
          hide-actions
        >
          <v-expansion-panel-header>
            <v-row
              align="center"
              class="spacer"
              no-gutters
            >
              <v-col
                cols="4"
                sm="2"
                md="1"
              >
                <v-btn class="center"
                  x-small
                  :loading="isLoading"
                  color="red lighten-1" 
                  fab dark
                  @click="deleteFeedback(feedback.id)"
                  >
                  <v-icon dark>mdi-close</v-icon>
                </v-btn>
              </v-col>

              <v-col
                cols="4"
                sm="2"
                md="1"
              >
                <v-avatar
                  size="36px"
                >
                  <img
                    v-if="feedback.user.image"
                    alt="Avatar"
                    :src="feedback.user.image"
                  >
                </v-avatar>
              </v-col>

              <v-col
                class="hidden-xs-only"
                sm="5"
                md="3"
              >
                <strong v-html="feedback.user.fullName"></strong>
              </v-col>

              <v-col
                class="text-no-wrap"
                cols="5"
                sm="3"
              >
                <strong v-html="feedback.user.email"></strong>
              </v-col>

              <v-col
                v-if="feedback.user.cnic"
                class="grey--text text-truncate hidden-sm-and-down"
              >
                &mdash;
                {{ feedback.user.cnic }}
              </v-col>
            </v-row>
          </v-expansion-panel-header>

          <v-expansion-panel-content>
            <v-divider></v-divider>
            <v-card-text v-text="feedback.content"></v-card-text>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-row>

    <v-snackbar
      :value="snack.trigger"
      centered
      app
      top
      :color="snack.type"
      text
    >
      {{snack.content}}
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
    data(){
        return{
            noFeedbacks: true,
            feedbacks: false,
            loader: false,
            isLoading: false,
            snack:{
              trigger: false,
              type: '',
              content: ''
            },
            data:{
              id: null
            }
        }
    },

    methods:{
      async deleteFeedback(id){
        this.data.id = id
        const res = await this.callApi('post', 'app/delete_feedback', this.data)
        this.isLoading = true
        if(res.status == 200){
          this.isLoading = false
          this.showSnack('success', 'Feedback deleted')
          this.getFeedbacks()
        }
      },

      showSnack(type, content){
        this.snack.type = type;
        this.snack.content = content
        this.snack.trigger = true

        setTimeout(()=> {
          this.snack.trigger = false
        }, 5000)
      },

      async getFeedbacks(){
        const res = await this.callApi('get', 'app/get_feedbacks')
        if(res.status == 200){
          this.feedbacks = res.data
          if(this.feedbacks != ""){
            this.noFeedbacks = false 
          }

        }
      },
    },

     created(){
       if(this.$store.state.user.isAdmin == 1){
          this.getFeedbacks()
          }
        else{
          window.location.href = '/404'
        }
    },
}
</script>

<style>

</style>