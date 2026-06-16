<template>
  <v-app>
    <v-main>
      <navbar></navbar>
      <v-container class="bg-dark mt-16">
        <Nuxt />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Navbar from '~/components/Navbar.vue'
export default {
  components: { Navbar },
  data() {
    return {}
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';
</style>
