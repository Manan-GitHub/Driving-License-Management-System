<template>
  <v-container>
      <h2 class="subheading orange--text text--darken-1">Processed Applications</h2>
      <v-simple-table
        class="mt-8"
      >
        <template v-slot:default>
          <thead class="indigo lighten-2">
            <tr>
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
                status
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
                <v-icon
                  v-if="application.status == 'disapproved'"
                  large
                  color="red lighten-1"
                >
                  mdi-cancel
                </v-icon>
                <v-icon
                  v-if="application.status == 'approved'"
                  large
                  color="green lighten-1"
                >
                  mdi-check
                </v-icon>
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
      showSnack(type, content){
        this.snack.type = type;
        this.snack.content = content
        this.snack.trigger = true

        setTimeout(()=> {
          this.snack.trigger = false
        }, 5000)
      },

      async getApplication(){
        const res = await this.callApi('get', 'app/get_processed_applications')
        this.loader = true
        if(res.status == 200){
          this.applications = res.data
          this.loader = false
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