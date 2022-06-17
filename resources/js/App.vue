<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <!--  -->
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item v-if="this.$store.state.user.isLicensed" to="/my-license">
            <v-list-item-icon>
              <v-icon>mdi-card-account-details</v-icon>
            </v-list-item-icon>
            <v-list-item-title>My License</v-list-item-title>
          </v-list-item>

          <v-list-item to="/">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>

          <v-list-item to="/rules">
            <v-list-item-icon>
              <v-icon>mdi-book-open-page-variant</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Rules</v-list-item-title>
          </v-list-item>

          <v-list-item to="/categories">
            <v-list-item-icon>
              <v-icon>mdi-shape</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Categories</v-list-item-title>
          </v-list-item>

          <v-list-item v-if="this.$store.state.user" @click="showCredentialDialog()">
            <v-list-item-icon>
              <v-icon>mdi-cog</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Change Credentials</v-list-item-title>
          </v-list-item>

          <v-list-item @click="feedbackDialog = true">
            <v-list-item-icon>
              <v-icon>mdi-help-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Help & Support</v-list-item-title>
          </v-list-item>

        </v-list-item-group>

        <v-list-group
        v-if="this.$store.state.user.isAdmin"
        :value="false"
        prepend-icon="mdi-account-group"
      >
        <template v-slot:activator>
          <v-list-item-title>Admin</v-list-item-title>
        </template>
        <v-list-item to="/users">
          <v-list-item-icon>
            <v-icon>mdi-account</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Users</v-list-item-title>
        </v-list-item>

        <v-list-item to="/licenses">
          <v-list-item-icon>
            <v-icon>mdi-card-account-details-star</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Licenses</v-list-item-title>
        </v-list-item>

        <v-list-item to="/applications">
          <v-list-item-icon>
            <v-icon>mdi-book</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Applications</v-list-item-title>
        </v-list-item>

        <v-list-item to="/processed-applications">
          <v-list-item-icon>
            <v-icon>mdi-book-check</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Processed Applications</v-list-item-title>
        </v-list-item>

        <v-list-item to="/feedbacks">
          <v-list-item-icon>
            <v-icon>mdi-message-bulleted</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Feedbacks</v-list-item-title>
        </v-list-item>
      </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-img
        class="mx-2"
        src="/img/logo_4.png"
        max-height="50"
        max-width="100"
        
      ></v-img>

      <v-spacer></v-spacer>  

       <v-btn v-if="!this.$store.state.user" to="/login" text class="orange--text text--darken-1">
           Login
        <v-icon right>mdi-login</v-icon>
      </v-btn>

       <v-btn v-if="!this.$store.state.user" @click="dialog = true" text class="orange--text text--darken-1">
           Signup
        <v-icon right>mdi-clipboard-edit-outline</v-icon>
      </v-btn>

       <v-btn v-if="this.$store.state.user" href="/logout" text class="red--text red--darken-1">
           Logout
        <v-icon right>mdi-logout</v-icon>
      </v-btn>

    </v-app-bar>

    <v-main>
      <!--  -->
      <router-view/>
    </v-main>

     <v-footer
    dark
    padless
    class="mt-10"
  >
    <v-card
      class="flex"
      flat
      tile
    >
      <v-card-title class="indigo lighten-1">
        <strong class="subheading">Stay <span class="orange--text text--darken-1">Alive</span> – Think and <span class="orange--text text--darken-1">Drive!</span></strong>

        <v-spacer></v-spacer>

        <v-btn
          class="mx-4"
          dark
          icon
          to="/"
        >
          <v-icon size="24px">
            mdi-home
          </v-icon>
        </v-btn>
        <v-btn
          class="mx-4"
          dark
          icon
          to="/rules"
        >
          <v-icon size="24px">
            mdi-book-open-page-variant
          </v-icon>
        </v-btn>
        <v-btn
          class="mx-4"
          dark
          icon
          to="/categories"
        >
          <v-icon size="24px">
            mdi-page-next
          </v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text class="py-2 white--text text-center">
        {{ new Date().getFullYear() }} — <strong>DLMS</strong>
      </v-card-text>
    </v-card>
  </v-footer>

      <!-- SIGNUP MODAL -->
          <v-dialog
      v-model="dialog"
      max-width="600px"
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >SIGNUP!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Full Name"
                  v-model="data.fullName"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Father/Husband Name"
                  v-model="data.father_husband_name"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="CNIC Number"
                  v-model="data.cnic"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="6"
              >
                <v-text-field
                  label="City"
                  v-model="data.city"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-select
                  v-model="data.state"
                  :items="states"
                  filled
                  rounded
                  label="State"
                  dense
                ></v-select>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Age"
                  v-model="data.age"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-select
                  v-model="data.gender"
                  :items="genders"
                  filled
                  rounded
                  label="gender"
                  dense
                ></v-select>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Permanent Address"
                  v-model="data.permanent_address"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Temporary Address"
                  v-model="data.temporary_address"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Email"
                  v-model="data.email"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="6">
                <v-text-field
                  label="Password"
                  type="password"
                  v-model="data.password"
                  @keyup.enter="signup()"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="6">
                <v-text-field
                  label="Confirm Password"
                  type="password"
                  v-model="data.confirmPassword"
                  color="indigo darken-1"
                  @keyup.enter="signup()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="8">
                <v-file-input
                  v-model="selectedFile"
                  label="Upload Passport-Size Image"
                  accept="image/png, image/jpeg, image/jpg"
                  filled
                  rounded
                  prepend-icon="mdi-cloud-upload"
                  @change="uploadImage()"
                ></v-file-input>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="dialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            
            @click="signup()"
          >
            Signup
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

          <!-- FEEDBACK MODAL -->
        <v-dialog
          v-model="feedbackDialog"
          max-width="600px"
          transition="dialog-top-transition"
        >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Help & Support!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <p>
                You can let us know in case you have any query regarding application and 
                renewal procedure of the driving license or you can simply leave us a
                feedback to help us improve our services here 
              </p>
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  v-model="feedback.content"
                  filled
                  color="indigo darken-1"
                  auto-grow
                  label="Your Feedback"
                  rows="4"
                  row-height="30"
                  rounded
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="12" md="2">
                <v-btn @click="sendFeedback()" rounded class="orange darken-1" >Send</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- UPDATE CREDENTIALS DIALOG -->
    <v-dialog
      v-model="credentialDialog"
      max-width="600px"
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Update Credentials!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Email"
                  v-model="updateData.email"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                  @keyup.enter="updateCredentials()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Current Password"
                  type="password"
                  v-model="updateData.currentPassword"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                  @keyup.enter="updateCredentials()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="6">
                <v-text-field
                  label="New Password"
                  type="password"
                  v-model="updateData.newPassword"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                  @keyup.enter="updateCredentials()"
                ></v-text-field>
              </v-col>  
              <v-col cols="12" sm="12" md="6">
                <v-text-field
                  label="Confirm Password"
                  type="password"
                  v-model="updateData.confirmPassword"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                  @keyup.enter="updateCredentials()"
                ></v-text-field>
              </v-col>  
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
          color="red darken-1"
          text
          @click="credentialDialog = false"
          >
          Cancel
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            @click="updateCredentials()"
          >
            Update
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- ALERT   -->
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
  </v-app>
</template>

<script>
  export default {

    props:['user'],

    data(){
      return{
        drawer: false,
        group: null,
        dialog: false,
        feedbackDialog: false,
        credentialDialog: false,
        isLoading: false,

        selectedFile: null,

        data:{
          fullName: '',
          father_husband_name: '',
          cnic: '',
          age: '',
          gender: '',
          city: '',
          state: '',
          permanent_address: '',
          temporary_address: '',
          email: '',
          password: '',
          confirmPassword:'',
          image: '',
        },

        updateData:{
          id: '',
          currentPassword: '',
          email: '',
          newPassword: '',
          confirmPassword: ''
        },

        feedback:{
          user_id: '',
          content: ''
        },

        snack:{
          trigger: false,
          type: '',
          content: ''
        },

        states: ['Punjab', 'Sindh', 'Balochistan', 'NWFP'],
        genders: ['Male', 'Female', 'Other']

      }
    },

    methods:{
      async signup(){
        if(this.data.fullName.trim() == '') return this.showSnack('error', 'Full Name must be provided')
        if(this.data.father_husband_name.trim() == '') return this.showSnack('error', 'Father/Husband name must be provided')
        if(this.data.cnic.trim() == '') return this.showSnack('error', 'CNIC must be provided')
        if(this.data.city.trim() == '') return this.showSnack('error', 'City name must be provided')
        if(this.data.age.trim() == '') return this.showSnack('error', 'Age must be provided')
        if(this.data.gender.trim() == '') return this.showSnack('error', 'Gender must be provided')
        if(this.data.state.trim() == '') return this.showSnack('error', 'State must be selected')
        if(this.data.cnic.length != 13) return this.showSnack('error', 'Invalid CNIC number')
        if(this.data.permanent_address.trim() == '') return this.showSnack('error', 'Permanent Address must be provided')
        if(this.data.temporary_address.trim() == '') return this.showSnack('error', 'Temporary Address must be provided')
        if(this.data.email.trim() == '') return this.showSnack('error', 'Email must be provided')
        if(this.data.password.trim() == '') return this.showSnack('error', 'Password must be provided')
        if(this.data.confirmPassword.trim() == '') return this.showSnack('error', 'Password must be confirmed')
        if(this.data.image.trim() == '') return this.showSnack('error', 'Image must be provided')
        if(this.data.password != this.data.confirmPassword ) return this.showSnack('error', 'Passwords did not match')

        this.data.image = `/uploads/${this.data.image}`
        this.isLoading = true
        const res = await this.callApi('post', 'app/signup', this.data)
        if(res.status == 201){
          this.isLoading = false
          this.showSnack('success', 'Signed Up Successfully!')
          this.dialog = false
          this.$router.push({name: 'login'})
          this.resetData()
        }

        else if(res.status==422){
          if(res.data.errors.fullName){
            this.showSnack('error', res.data.errors.fullName[0])
            this.isLoading = false
          }
          if(res.data.errors.father_husband_name){
            this.showSnack('error', res.data.errors.father_husband_name[0])
            this.isLoading = false
          }
          if(res.data.errors.age){
            this.showSnack('error', res.data.errors.age[0])
            this.isLoading = false
          }
          if(res.data.errors.age){
            this.showSnack('error', res.data.errors.gender[0])
            this.isLoading = false
          }
          if(res.data.errors.city){
            this.showSnack('error', res.data.errors.city[0])
            this.isLoading = false
          }
          if(res.data.errors.state){
            this.showSnack('error', res.data.errors.state[0])
            this.isLoading = false
          }
          if(res.data.errors.cnic){
            this.showSnack('error', res.data.errors.cnic[0])
            this.isLoading = false
          }
          if(res.data.errors.address){
            this.showSnack('error', res.data.errors.address[0])
            this.isLoading = false
          }
          if(res.data.errors.email){
            this.showSnack('error', res.data.errors.email[0])
            this.isLoading = false
          }
          if(res.data.errors.password){
            this.showSnack('error', res.data.errors.password[0])
            this.isLoading = false
          }
          if(res.data.errors.image){
            this.showSnack('error', res.data.errors.image[0])
            this.isLoading = false
          }
        }
        
        else{
          this.showSnack('error', 'Something went wrong')
          this.isLoading = false
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

    async uploadImage() {
        if(!this.selectedFile){
          this.showSnack('error', 'Image must be provided')
        }
        else{
          let formData = new FormData()
          formData.append('file', this.selectedFile, this.selectedFile.name)
   
          axios.post('app/upload', formData)
            .then(res => {
              this.data.image = res.data
              console.log(this.data.image)
            })
            .catch(err => {})
        }
    },

    async sendFeedback(){
      if(!this.$store.state.user) return this.showSnack('error', 'You must log in to perform this action')
      if(this.feedback.content.trim() == '') return this.showSnack('error', 'Feedback can not be empty')
      this.feedback.user_id = this.$store.state.user.id
      const res = await this.callApi('post', 'app/send_feedback', this.feedback)
      if(res.status == 200){
        console.log(res.data)
        this.showSnack('success', 'Thanks for your response')
        this.feedbackDialog = false
      }
      else{
        this.showSnack('error', 'Something went wrong')
      }
    },

    resetData(){
      this.data.fullName = ''
      this.data.father_husband_name = ''
      this.data.cnic = ''
      this.data.age = ''
      this.data.city = ''
      this.data.state = ''
      this.data.permanent_address = ''
      this.data.temporary_address = ''
      this.data.email = ''
      this.data.password = ''
      this.data.confirmPassword = ''
      this.data.image = ''
      this.selectedFile = null

      this.feedback.user_id = ''
      this.feedback.content = ''
    },
    showCredentialDialog(){
      this.updateData.id = this.$store.state.user.id
      this.updateData.email = this.$store.state.user.email
      this.credentialDialog = true
    },

    async updateCredentials(){
      if(this.updateData.email.trim() == '') return this.showSnack('error', 'Email must be provided')
      if(this.updateData.currentPassword.trim() == '') return this.showSnack('error', 'Current Password must be provided')
      if(this.updateData.newPassword.trim() == '') return this.showSnack('error', 'New Password must be provided')
      if(this.updateData.confirmPassword.trim() == '') return this.showSnack('error', 'New Password must be confirmed')
      if(this.updateData.newPassword != this.updateData.confirmPassword ) return this.showSnack('error', 'Passwords did not match')
      this.isLoading = true
      const res = await this.callApi('post', 'app/update_user', this.updateData)
      if(res.status == 200){
          this.isLoading = false
          this.showSnack('success', 'Credentials Updated Successfully!')
          this.credentialDialog = false
          this.updateData.email = ''
          this.updateData.currentPassword = ''
          this.updateData.newPassword = ''
          this.updateData.confirmPassword = ''
        }

        else if(res.status==422){
          if(res.data.errors.email){
            this.showSnack('error', res.data.errors.email[0])
            this.isLoading = false
          }
          if(res.data.errors.currentPassword){
            this.showSnack('error', res.data.errors.currentPassword[0])
            this.isLoading = false
          }
          if(res.data.errors.newPassword){
            this.showSnack('error', res.data.errors.newPassword[0])
            this.isLoading = false
          }
          if(res.data.errors.confirmPassword){
            this.showSnack('error', res.data.errors.confirmPassword[0])
            this.isLoading = false
          }
        }

        else if(res.status == 401){
          this.isLoading = false
          this.showSnack('error', res.data.msg)
        }
        
        else{
          this.showSnack('error', 'Something went wrong')
          this.isLoading = false
        }
    }
    
    },

    created(){
        this.$store.commit('updateUser', this.user)
    },
  }
</script>
