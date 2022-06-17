<template>
  <v-container>
    <h1 class="indigo--text text--lighten-2 text-center">License Categories</h1>
    <v-expansion-panels>
      <v-expansion-panel>
          <v-expansion-panel-header disable-icon-rotate>
            LTV
            <template v-slot:actions>
              <v-icon color="orange darken-1">
                mdi-page-next
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text text--darken-1">
            light transport vehicle driving license is valid for commercial car/taxi, jeep, mini bus, Mazda and lightweight transport.
          </v-expansion-panel-content>
        </v-expansion-panel>

      <v-expansion-panel>
          <v-expansion-panel-header disable-icon-rotate>
            HTV
            <template v-slot:actions>
              <v-icon color="orange darken-1">
                mdi-page-next
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text text--darken-1">
            HTV: Heavy transport vehicle driving license is valid for buses, trucks, trailers, cranes, and any type of heavy transport.
          </v-expansion-panel-content>
        </v-expansion-panel>
        
      <v-expansion-panel>
          <v-expansion-panel-header disable-icon-rotate>
            PSV
            <template v-slot:actions>
              <v-icon color="orange darken-1">
                mdi-page-next
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text text--darken-1">
            PSV stands for Public Service Vehicle and PSV License will be issued after passing 01 year of LTV/HTV License. On LTV/PSV License you can drive light passenger vehicles like Wagon, Euro, Bolan etc. and on HTV/PSV License you can drive heavy passenger vehicles like Bus (Metro Bus/Daewoo Bus/Coaster etc.)
          </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
  </v-container>
</template>

<script>
export default {

}
</script>

<style>

</style>