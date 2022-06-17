<template>
  <v-container>
      <h2 class="subheading orange--text text--darken-1">Unprocessed Applications</h2>
      <v-simple-table
        class="mt-8"
      >
        <template v-slot:default>
          <thead class="indigo lighten-2">
            <tr>
              <th class="text-center white--text">
                Date
              </th>
              <th class="text-center white--text">
                Application Number
              </th>
              <th class="text-center white--text">
                Name
              </th>
              <th class="text-center white--text">
                CNIC
              </th>
              <th class="text-center white--text">
                City
              </th>
              <th class="text-center white--text">
                License Type
              </th>
              <th class="text-center white--text">
                Medical Certificate
              </th>
              <th class="text-center white--text">
                Actions
              </th>
            </tr>
          </thead>
          <tbody v-if="applications">
            <tr
              class="text-center"
              v-for="application in applications"
              :key="application.id"
            >
              <td>
                {{currentDate(application.created_at)}}
              </td>
              <td>
                {{application.application_No}}
              </td>
              <td>{{ application.user.fullName }}</td>
              <td>{{ application.user.cnic }}</td>
              <td>{{ application.user.city }}</td>
              <td>{{ application.license_type }}</td>
              <td>
                <v-btn icon :to="{ name: 'image', params: { image: application.medical_certificate  } }">
                  <v-icon>mdi-link-variant</v-icon>
                </v-btn>
              </td>
              <td>
                <v-btn 
                  x-small
                  class="ma-1"
                  :loading="isLoading"
                  color="red lighten-1" 
                  fab dark
                  @click="disapproveApplication(application.id)"
                  >
                  <v-icon dark>mdi-close</v-icon>
                </v-btn>
                <v-btn 
                  x-small
                  class="ma-1"
                  :loading="isLoading"
                  color="green lighten-1" 
                  fab dark
                  @click="approveApplication(application.id)"
                  >
                  <v-icon dark>mdi-check</v-icon>
                </v-btn>
                <v-btn 
                  v-if="!application.email_sent"
                  x-small
                  class="ma-1"
                  :loading="isLoading"
                  color="orange darken-1" 
                  fab dark
                  @click="sendEmail(application.id)"
                  >
                  <v-icon dark>mdi-email</v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row justify="center" class="mt-5"> 
        <v-col offset="5">
          <v-progress-circular
            v-show="loader"
            :size="70"
            :width="7"
            color="indigo lighten-2"
            indeterminate
          ></v-progress-circular>
        </v-col>
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
import moment from 'moment';
export default {
    data(){
        return{
            applications: [],
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
      currentDate(date) {
      return moment(date, "YYYYMMDD").fromNow()
      },

      showSnack(type, content){
        this.snack.type = type;
        this.snack.content = content
        this.snack.trigger = true

        setTimeout(()=> {
          this.snack.trigger = false
        }, 5000)
      },

      async getApplication(){
        const res = await this.callApi('get', 'app/get_applications')
        this.loader = true
        if(res.status == 200){
          this.applications = res.data
          this.loader = false
        }
      },

      async sendEmail(id){
        this.data.id = id
        const res = await this.callApi('post', 'app/send_email', this.data)
        if(res.status == 200){
          this.getApplication()
          this.showSnack('success', 'Email sent')
        }
      },

      async disapproveApplication(id){
        this.data.id = id
        const res = await this.callApi('post', 'app/disapprove_application', this.data)
        if(res.status == 200){
          this.getApplication()
          this.showSnack('success', 'Application has been disapproved and sent to processed applications')
        }
      },

      async approveApplication(id){
        this.data.id = id
        const res = await this.callApi('post', 'app/approve_application', this.data)
        if(res.status == 200){
          this.getApplication()
          this.showSnack('success', 'Application has been approved and sent to processed applications')
        }
      },
    },

     created(){
        if(this.$store.state.user.isAdmin == 1){
          this.getApplication()
          }
        else{
          window.location.href = '/404'
        }
    },
}
</script>

<style>

</style>