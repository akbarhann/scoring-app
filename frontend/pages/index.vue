<template>
  <div class="main">
    <div class="wrapper">
      <p dark class="text-center mt-4 text-30 font-weight-semi">LOGIN</p>
      <v-form dark class="pt-5">
        <div class="mb-5">
          <v-text-field
            v-model="username"
            color="grey lighten-5"
            label="Username"
            @keyup.enter="login()"
          ></v-text-field>
          <v-text-field
            v-model="password"
            label="Password"
            :type="showPassword ? 'text' : 'password'"
            :append-icon="
              showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
            "
            color="grey lighten-5"
            @keyup.enter="login()"
            @click:append="showPassword = !showPassword"
          ></v-text-field>
        </div>
        <v-btn block large @click="login()">Login</v-btn>
      </v-form>
    </div>

    <v-snackbar v-model="snackbar" timeout="1000" top color="red darken-4">
      <span>{{ errorMessage }}</span>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  name: 'LandingPage',
  middleware({ redirect, app }) {
    if (app.$cookies.get('user_auth')) {
      return redirect('/user/dashboard')
    }
  },
  data() {
    return {
      username: '',
      password: '',
      showPassword: false,
      loadingSubmit: false,

      snackbar: false,
      errorMessage: '',
    }
  },
  methods: {
    login() {
      this.loadingSubmit = true
      if (this.username === 'admin' && this.password === 'adminmasuk2123') {
        this.$cookies.set('user_auth', 'admin', {
          path: '/',
          maxAge: 60 * 60 * 24 * 7,
        })
        setTimeout(() => {
          this.$router.push('/user/dashboard')
        }, 10)
        this.loadingSubmit = false
      } else {
        this.errorMessage = 'Wrong Usename/password'
        this.snackbar = true
        this.loadingSubmit = false
      }
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.wrapper {
  max-width: 350px;
  min-height: 430px;
  margin: 80px auto;
  padding: 40px 30px 30px 30px;
  /* background-color: #121212;
  border-radius: 15px;
  box-shadow: 13px 13px 20px #000000bb, -13px -13px 20px rgba(39, 38, 38, 0.678); */
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
    #121212;
  box-shadow: 11px 11px 62px 7px #000000,
    -11px -11px 51px 1px rgba(48, 48, 48, 0.54);
  backdrop-filter: blur(14px);
  border-radius: 20px;
}
</style>
