import colors from 'vuetify/es5/util/colors'

export default {
  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  srcDir: 'frontend/',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s scoring-app',
    title: '',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,600,700,800,900',
      },
    ],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [{ src: '~/plugins/filters.js' }],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    'cookie-universal-nuxt',
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: 'https://api-scoring.pbjisurabaya.or.id',
    proxyHeaders: false,
    credentials: false,
    proxy: false,
    debug: false,
    progress: false,
    https: true,
  },
  // axios: {
  //   baseURL: 'http://localhost:8000',
  //   proxyHeaders: false,
  //   credentials: true,
  //   proxy: true,
  //   debug: false,
  //   progress: false,
  //   https: true,
  // },

  proxy: {
    // '/api/': 'http://localhost:8000',
    // '/api/': 'https://scoring.pbjisurabaya.or.id',
    '/api/': {
      target: 'https://api-scoring.pbjisurabaya.or.id',
      pathRewrite: { '^/api/': '/api/' },
      changeOrigin: true,
    },
    '/api2/': {
      target: 'https://api.challonge.com',
      pathRewrite: { '^/api2/': '/v1/' },
      changeOrigin: true,
    },
    '/api3/': {
      target:
        'https://baramubarok:BAMtLseJZv1T832RxfuQDWvxGbX2wdoPEjgeGAAC@api.challonge.com',
      pathRewrite: { '^/api3/': '/v1/' },
      changeOrigin: true,
    },
  },

  generate: {
    fallback: true,
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    treeShake: true,
    defaultAssets: {
      font: {
        family: 'Poppins',
      },
    },
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3,

          // My color Pallete
          primarydark: '#31323B',
          primaryblue: '#243C7A',
          primaryred: '#EF233C',
          secondaryblue: '#0048FF',
          secondaryred: '#FF001E',
        },
      },
    },
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
}
