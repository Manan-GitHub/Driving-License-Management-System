<template>
  <div>
          <!-- MODAL -->
          <v-dialog
      v-model="dialog"
      max-width="600px"
      persistent
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >LOGIN!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Email"
                  v-model="data.email"
                  color="indigo darken-1"
                  @keyup.enter="login()"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Password"
                  type="password"
                  v-model="data.password"
                  @keyup.enter="login()"
                  color="indigo darken-1"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>  
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
          color="indigo darken-1"
          text
          to="/"
          >
          <v-icon
            left
          >
            mdi-arrow-left
          </v-icon>Home
          </v-btn>
          <v-btn
          class="mx-auto"
          color="indigo darken-1"
          text
          @click="showForgotPasswordDialog()"
          >
          Forgot Password?
          </v-btn>
          
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            
            @click="login()"
          >
            Login
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="forgotPasswordDialog"
      max-width="600px"
      persistent
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Send Email!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  label="Email"
                  v-model="fpData.email"
                  color="indigo darken-1"
                  @keyup.enter="changePassword()"
                  hint="Enter Your Email To Receive The New Password"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
          color="indigo darken-1"
          text
          to="/"
          >
          <v-icon
            left
          >
            mdi-arrow-left
          </v-icon>Home
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            
            @click="changePassword()"
          >
            Send
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
  </div>
</template>

<script>
export default {
    data(){
        return{
            dialog: true,
            forgotPasswordDialog: false,
            isLoading: false,

            snack:{
                trigger: false,
                type: '',
                content: ''
            },    

            data:{
                email: '',
                password: ''
            },
            fpData:{
              email: ''
            }
        }
    },

    methods:{
        async login(){
            if(this.data.email.trim() == '') return this.showSnack('error', 'Email must be entered')
            if(this.data.password.trim() == '') return this.showSnack('error', 'Password must be entered')
            this.isLoading = true
            const res = await this.callApi('post', 'app/login', this.data)
            if(res.status == 200){
            this.isLoading = false
            this.dialog = false
            window.location = '/'
            }

            else if(res.status == 422){
                if(res.data.errors.email){
                    this.showSnack('error', res.data.errors.email[0])
                    this.isLoading = false
                }
                if(res.data.errors.password){
                    this.showSnack('error', res.data.errors.password[0])
                    this.isLoading = false
                }
            }

            else if(res.status == 401){
              this.showSnack('error', 'Incorrect Email or Password')
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

      showForgotPasswordDialog(){
        this.dialog = false
        this.forgotPasswordDialog = true
      },
      async changePassword(){
        if(this.fpData.email.trim() == '') return this.showSnack('error', 'Email must be entered')
        this.isLoading = true
        const res = await this.callApi('post', 'app/change_password', this.fpData)
        if(res.status == 200){
          this.isLoading = false
          this.forgotPasswordDialog = false
          this.dialog = true
          this.showSnack('success', 'Your new password has been sent to your email address. Kindly change it as soon as possible')
        }
        else if(res.status == 401){
          this.isLoading = false
          this.showSnack('error', res.data.msg)
        }
        else if(res.status==422){
          if(res.data.errors.email){
            this.showSnack('error', res.data.errors.email[0])
            this.isLoading = false
          }
        }
        else{
          this.showSnack('error', 'Something went wrong')
          this.isLoading = false
        }
      }
    }
}
</script>

<style>

</style>