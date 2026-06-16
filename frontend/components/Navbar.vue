<template>
  <div>
    <v-app-bar absolute color="grey darken-4" elevate-on-scroll>
      <v-container class="d-flex w-100 justify-end">
        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon class="rotate-270deg">mdi-tray-arrow-up</v-icon>
        </v-btn>
      </v-container>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  name: 'NavbarComponent',
  data() {
    return {}
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';
</style>
