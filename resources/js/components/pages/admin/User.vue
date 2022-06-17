<template>
  <v-container>
      <h2 class="subheading orange--text text--darken-1">Users</h2>
      <v-simple-table
      >
        <template v-slot:default>
          <thead class="indigo lighten-2">
            <tr>
              <th class="text-center white--text">
                image
              </th>
              <th class="text-center white--text">
                Name
              </th>
              <th class="text-center white--text">
                Father/Husband Name
              </th>
              <th class="text-center white--text">
                CNIC
              </th>
              <th class="text-center white--text">
                Age
              </th>
              <th class="text-center white--text">
                City
              </th>
              <th class="text-center white--text">
                Actions
              </th>
            </tr>
          </thead>
          <tbody v-if="users">
            <tr
              class="text-center"
              v-for="user in users"
              :key="user.id"
            >
              <td>
                <v-avatar class="my-2">
                  <img
                    :src="user.image"
                  >
                </v-avatar>
              </td>
              <td>{{ user.fullName }}</td>
              <td>{{ user.father_husband_name }}</td>
              <td>{{ user.cnic }}</td>
              <td>{{ user.age }}</td>
              <td>{{ user.city }}</td>
              <td>
                <v-btn 
                  x-small
                  :loading="isLoading"
                  color="red lighten-1" 
                  fab dark
                  @click="deleteUser(user.id)"
                  >
                  <v-icon dark>mdi-delete</v-icon>
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
export default {
    data(){
        return{
            users: [],
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
      async deleteUser(id){
        this.data.id = id
        const res = await this.callApi('post', 'app/delete_user', this.data)
        this.isLoading = true
        if(res.status == 200){
          this.isLoading = false
          this.getUser()
          this.showSnack('success', 'User deleted successfully')
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

      async getUser(){
        const res = await this.callApi('get', 'app/get_users')
        this.loader = true
        if(res.status == 200){
          this.users = res.data
          this.loader = false
        }
      },
    },

     created(){
       if(this.$store.state.user.isAdmin == 1){
          this.getUser()
          }
        else{
          window.location.href = '/404'
        }
    },
}
</script>

<style>

</style>