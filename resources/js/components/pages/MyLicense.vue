<template>
  <v-container class="mt-10">
    <div 
      v-for="(user, i) in users"
      :key="i"
    >
      <v-alert
        v-if="!user.license.status"
        prominent
        type="error"
        max-width="600"
        class="mx-auto mb-0 text-center"
      >
        <v-row align="center">
          <v-col class="grow">
            <h2>Your Driving License Has Expired!</h2>
            <p>Kindly renew your drving lincense</p>
          </v-col>
        </v-row>
      </v-alert>
      <v-alert
        border="top"
        color="indigo"
        max-width="600"
        class="mx-auto mb-0 text-center"
        dark
      >
        <h2 class="orange--text text--darken-1 h4">Driving License Management System</h2>
      </v-alert>
      <v-card
        :disabled="!user.license.status"
        class="mx-auto"
        max-width="600"
        tile
      
      >
        <v-img
          height="100%"
          src="/img/profile_bg.jpg"
        >
          <v-row
            align="end"
            class="fill-height"
          >
            <v-col
              align-self="start"
              class="pa-0"
              cols="6"
            >
              <v-avatar
                class="profile"
                color="grey"
                size="174"
                tile
              >
                <v-img :src="user.image"></v-img>
              </v-avatar>
            </v-col>
            <v-spacer></v-spacer>
            <v-col
              align-self="start"
              class="pa-0"
              cols="5"
            >
              <v-avatar
                size="174"
                tile
              >
                <v-img src="/img/logo_1.png"></v-img>
              </v-avatar>
            </v-col>
            <v-col class="py-0">
              <v-list-item
                color="rgba(0, 0, 0, .4)"
                dark
              >
                <v-list-item-content>
                  <v-list-item-title class="text-h6">
                    Name: {{user.fullName}}
                  </v-list-item-title>
                  <v-list-item-title class="text-h6">
                    S/O: {{user.father_husband_name}}
                  </v-list-item-title>
                  <v-list-item-title class="text-h6">
                    Gender: {{user.gender}}
                  </v-list-item-title>
                  <v-list-item-subtitle>Issue Date: {{formatDate(user.license.created_at)}}</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-col>
            <v-col class="py-0">
              <v-list-item
                color="rgba(0, 0, 0, .4)"
                dark
              >
                <v-list-item-content>
                  <v-list-item-title class="text-h6">
                    CNIC: {{user.cnic}}
                  </v-list-item-title>
                  <v-list-item-title class="text-h6">
                    License No. {{user.license.license_no}}
                  </v-list-item-title>
                  <v-list-item-title class="text-h6">
                    License Type: {{user.license.license_type}}
                  </v-list-item-title>
                  <v-list-item-subtitle>Valid Upto: {{formatDate(user.license.expiry_date)}}</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-col>
          </v-row>
        </v-img>
      </v-card>
    </div>
  </v-container>
</template>

<script>
import moment from 'moment';
export default {

    data(){
      return{
        users:[],
        data: {
          id: ''
        },
        alert: false,
      }
    },

    methods:{
      formatDate(date) {
      return moment(date).format("MMM Do YY");
      },
    },

    async created(){
      this.data.id = this.$store.state.user.id
      console.log(this.data.id)
      const res = await this.callApi('post', 'app/get_user_with_license', this.data)
      if(res.status == 200){
        this.users = res.data
        console.log(this.users)
      }
    }
}
</script>

<style>

</style>