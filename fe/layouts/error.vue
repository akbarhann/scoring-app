<template>
  <v-app dark>
    <v-main>
      <div class="d-flex justify-space-around" style="height: 100%">
        <div class="align-self-center">
          <h1 v-if="error.statusCode === 404" class="text-sm-33">
            {{ pageNotFound }}
          </h1>
          <h1 v-else class="text-sm-33">
            <!-- {{ otherError }} -->
            Server Error
          </h1>
          <p
            class="text-center primary--text text-20 text-sm-16 pointer"
            @click="$router.go(-1)"
          >
            <span
              ><v-icon class="primary--text text-18"
                >mdi-arrow-left</v-icon
              ></span
            >
            Back
          </p>
        </div>
      </div>
    </v-main>
  </v-app>
</template>

<script>
export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
    }
  },
  head() {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title,
    }
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';
h1 {
  font-size: 80px;
}

.home {
  font-size: 25px;
}
</style>
