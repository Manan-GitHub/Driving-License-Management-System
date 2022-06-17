<template>
  <v-container>
      <h2 class="subheading orange--text text--darken-1">Licenses</h2>
      <v-simple-table
        class="mt-8"
      >
        <template v-slot:default>
          <thead class="indigo lighten-2">
            <tr>
              <th class="text-center white--text">
                License Number
              </th>
              <th class="text-center white--text">
                Name
              </th>
              <th class="text-center white--text">
                CNIC
              </th>
              <th class="text-center white--text">
                License Type
              </th>
              <th class="text-center white--text">
                Expiry Date
              </th>
              <th class="text-center white--text">
                status
              </th>
            </tr>
          </thead>
          <tbody v-if="licenses">
            <tr
              class="text-center"
              v-for="license in licenses"
              :key="license.id"
            >
              <td>
                {{license.license_no}}
              </td>
              <td>{{ license.user.fullName }}</td>
              <td>{{ license.user.cnic }}</td>
              <td>{{ license.license_type }}</td>
              <td>{{ license.expiry_date }}</td>
              <td>
                <div
                  v-if="license.status == 0"
                  class="red--text text--lighten-1"
                >
                  Expired
                </div>
                <div
                  v-if="license.status == 1"
                  class="green--text text--lighten-1"
                >
                  Valid
                </div>
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
            licenses: [],
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

      async getLicense(){
        const res = await this.callApi('get', 'app/get_licenses')
        this.loader = true
        if(res.status == 200){
          this.licenses = res.data
          this.loader = false
        }
      },

    },

     created(){
       if(this.$store.state.user.isAdmin == 1){ 
          this.getLicense()
          }
        else{
          window.location.href = '/404'
        }
    },
}
</script>

<style>

</style>