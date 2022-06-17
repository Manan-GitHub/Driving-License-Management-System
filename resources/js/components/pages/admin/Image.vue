<template>
  <v-container>
       <v-dialog
      v-model="dialog"
      max-width="600px"
      transition="dialog-top-transition"
      overlay-opacity="1"
      persistent
    >
      <v-card>
        <v-card-title >
          <span class="text-h5 orange--text text--darken-1" >Medical Certificate</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row justify="center">
                <v-img :src="this.image"></v-img>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
          color="indigo darken-1"
          text
          @click="$router.go(-1)"
          >
          <v-icon
            left
          >
            mdi-arrow-left
          </v-icon>Back
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
    props: ['image'],
    data(){
        return{
            dialog: true
        }
    },
}
</script>

<style>

</style>