<template>
  <div>
    <v-parallax
      id="#mdi-home"
      dark
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
    >
      <v-row
        align="center"
        justify="center"
      >
        <v-col
          class="text-center"
          cols="12"
        >
          <h1 class="text-h4 font-weight-thin mb-4">
            Welcome To <span class="orange--text text--darken-1">DLMS</span>
          </h1>
          <h4 class="subheading">
            Easy way to apply for driving license
          </h4>
          <v-btn class="orange darken-1 mt-2" @click="showApplicationDialog()">Apply</v-btn>
        </v-col>
      </v-row>
    </v-parallax>


    <v-row justify="center" class="mt-10">
      <v-col cols="8" class="">
        <v-card color="basil" flat>
          <v-card-title class="text-center justify-center py-6">
            <h2 class="font-weight-bold text-h2 indigo--text text--lighten-2">
              About <b class="orange--text text--darken-1">DLMS</b>
            </h2>
          </v-card-title>
          <v-tabs
            v-model="tab"
            background-color="transparent"
            color="indigo"
            grow
          >
            <v-tab
              v-for="item in items"
              :key="item.id"
            >
              {{ item.name }}
            </v-tab>
          </v-tabs>
          <v-tabs-items v-model="tab">
            <v-tab-item
              v-for="item in items"
              :key="item.id"
            >
              <v-card
                color="basil"
                flat
              >
                <v-card-text>{{ item.body }}</v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
        </v-card>
      </v-col>
    </v-row>


    <v-parallax
      class="mt-10"
      dark
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
    >
      <v-row
        align="center"
        justify="center"
      >
        <v-col
          class="text-center"
          cols="12"
        >
          <h1 class="text-h4 font-weight-thin mb-4">
            Renew Your Driving License
          </h1>
          <v-btn @click="showRenewalDialog()" class="orange darken-1 mt-2">Renew</v-btn>
        </v-col>
      </v-row>
    </v-parallax>


    <v-row class="mt-10 mx-auto" justify="center">
      <v-col cols="12" md="5" sm="12">
        <v-hover>
          <template v-slot:default="{ hover }">
            <v-card
              class="mx-auto"
              max-width="auto"
              flat
            >
              <v-img src="/img/rules.svg" height="300"></v-img>

              <v-fade-transition>
                <v-overlay
                  v-if="hover"
                  absolute
                  color="#036358"
                >
                  <v-btn to="/rules">Learn More About Rules</v-btn>
                </v-overlay>
              </v-fade-transition>
            </v-card>
          </template>
        </v-hover>
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="12" md="5" sm="12">
        <v-hover>
          <template v-slot:default="{ hover }">
            <v-card
              class="mx-auto"
              max-width="auto"
              flat
            >
              <v-img src="/img/home_vehicle.svg" height="300"></v-img>

              <v-fade-transition>
                <v-overlay
                  v-if="hover"
                  absolute
                  color="#036358"
                >
                  <v-btn to="/categories">Learn More About License Categories</v-btn>
                </v-overlay>
              </v-fade-transition>
            </v-card>
          </template>
        </v-hover>
      </v-col>
    </v-row>

      <!-- MODAL -->
          <v-dialog
      v-model="applicationDialog"
      max-width="600px"
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Apply for Driving License Here!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-select
                  v-model="data.license_type"
                  :items="licenseTypes"
                  filled
                  rounded
                  label="Select License Type"
                  dense
                ></v-select>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-file-input
                  v-model="selectedFile"
                  label="Upload Medical Certificate"
                  accept="image/png, image/jpeg, image/jpg"
                  filled
                  rounded
                  prepend-icon="mdi-cloud-upload"
                  @change="uploadImage()"
                ></v-file-input>
              </v-col>

              <v-col cols="12" sm="12" md="12">
                <div id="paypal-button-container"></div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="applicationDialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            @click="apply()"
          >
            Apply
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

          <!-- MODAL -->
          <v-dialog
      v-model="renewalDialog"
      max-width="600px"
      transition="dialog-top-transition"
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Renew Your Driving License Here!</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
              <v-col
                cols="12"
                sm="12"
                md="8"
              >
                <v-text-field
                  label="License Number"
                  v-model="renewalData.licenseNo"
                  color="indigo darken-1"
                  @keyup.enter="renew()"
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
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="renewalDialog = false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="indigo darken-1"
            text
            :loading="isLoading"
            @click="renew()"
          >
            Renew
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
  </div>
</template>

<script>
export default {
    data(){
      return {
        selectedFile: null,
        licenseTypes: ['LTV', 'HTV', 'PSV',],
        data:{
          user_id: '',
          medical_certificate: '',
          license_type: '',
        },
        renewalData:{
          licenseNo: '',
          user_id: ''
        },
        paymentData:{
          id: ''
        },
        tab: null,
        applicationDialog: false,
        renewalDialog: false,
        isLoading: false,
        items:[
          {id: 1, name:'Introduction', body:'Driving License Management System (DLMS) automates the processes for driving license issuance, renewal and upgrades. These activities are carried out throughout Pakistan. This system provides quick processing service to public and up to date statistics to the authorities by using state of the art technology and equipment. The system redefines the issuance process of all types of licenses by using a centralized network.'},
          {id: 2, name:'Customer Care Standards', body:'The customer care standards will be enhanced in such a way that the applicant will only have to visit the licensing testing center and upon passing the test, the applicant will get internationally renowned Secured Card based driving license. In order to have a self-sustainable model to continue giving best service delivery to the general public, revolving fund will be created for inward and outward transactions.'},
          {id: 3, name:'Salient Features', body:'Driving License Issuance Management System (DLMS) Phase-II automates the processes for driving license issuance, renewal and upgrades. These activities are carried out throughout the province of Punjab. This system provides quick processing service to public and up to date statistics to the authorities by using state of the art technology and equipment. The system redefines the issuance process of all types of licenses by using a centralized network.'},
        ],

        snack:{
          trigger: false,
          type: '',
          content: ''
        },
      }
    },

    methods:{
      async apply(){
        if(this.$store.state.user == false) return this.showSnack('error', 'You must log in to apply for the driving license')
        if(this.data.license_type.trim() == '') return this.showSnack('error', 'License Type must be selected')
        if(this.data.medical_certificate.trim() == '') return this.showSnack('error', 'Medical Certificate must be provided')

        this.data.medical_certificate = `/uploads/${this.data.medical_certificate}`
        this.isLoading = true
        const res = await this.callApi('post', 'app/apply', this.data)
        if(res.status == 201){
          this.isLoading = false
          this.showSnack('success', 'Your application has been received. You are being redirected to payment gateway to pay up for the application charges otherwise your application shall be discarded. Thank you!')
          this.applicationDialog = false
          setTimeout(()=> {
            window.location.href = '/paypal'
          }, 5000)
        }

        else if(res.status==422){
          if(res.data.errors.license_type){
            this.showSnack('error', res.data.errors.license_type[0])
            this.isLoading = false
          }
          
          if(res.data.errors.medical_certificate){
            this.showSnack('error', res.data.errors.medical_certificate[0])
            this.isLoading = false
          }
        }

        else if(res.status == 401){
          this.showSnack('error', res.data.msg)
          this.isLoading = false
        }
        
        else{
          this.showSnack('error', 'Something went wrong')
          this.isLoading = false
        }
      },

      async uploadImage() {
        if(!this.selectedFile){
          this.showSnack('error', 'Medical certificate must be provided')
        }
        else{
          let formData = new FormData()
          formData.append('file', this.selectedFile, this.selectedFile.name)
   
          axios.post('app/upload', formData)
            .then(res => {
              this.data.medical_certificate = res.data
              this.data.user_id = this.$store.state.user.id
              console.log(this.data.medical_certificate)
            })
            .catch(err => {})
        }
    },

      showApplicationDialog(){
        if(this.$store.state.user == false) return this.showSnack('error', 'You must log in to apply for the driving license')
        else if(this.$store.state.user.hasApplied == true){
          return this.showSnack('error', 'You have already applied for the driving license. You can not apply for more than 1 license at once')
        }
        else{
          this.applicationDialog = true
        }
      },

      showRenewalDialog(){
        if(this.$store.state.user == false) return this.showSnack('error', 'You must log in to renew your driving license')
        else if(this.$store.state.user.hasApplied == true){
          return this.showSnack('error', 'You can not get your license renewed while you have already applied for a new one')
        }
        else{
          this.renewalDialog = true
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

      async renew(){
        if(this.$store.state.user == false) return this.showSnack('error', 'You must log in to renew your driving license')
        if(this.renewalData.licenseNo.trim() == '') return this.showSnack('error', 'License number must be provided')
        this.renewalData.user_id = this.$store.state.user.id
        this.isLoading = true
        const res = await this.callApi('post', 'app/renew', this.renewalData)
        if(res.status == 200){
          this.isLoading = false
          this.showSnack('success', 'You are being redirected to payment gateway to pay up for renewal charges. Thank you!')
          this.renewalData.user_id = ''
          this.renewalData.licenseNo = ''
          this.renewalDialog = false
          setTimeout(()=> {
            window.location.href = '/renewal_paypal'
          }, 5000)
        }

        if(res.status == 401){
          this.isLoading = false
          this.showSnack('error', res.data.msg)
        }
      },

    },
    
}
</script>

<style>

</style>