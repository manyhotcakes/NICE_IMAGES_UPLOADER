const webpack = require("webpack")
const {parsed: dotenv} = require('dotenv').config()

module.exports = {
  /*
  ** Headers of the page
  */
  mode: "spa",
  srcDir: "./nuxt",
  head: {
    title: 'homework',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js + Vuetify.js project in Laravel' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' }
    ]
  },
  plugins: [
    '~/plugins/globals.js',
    '~/plugins/vuetify.js',
    '~/plugins/veevalidate.js',
    '~/plugins/axios.js'
  ],
  css: [
    '~/assets/style/app.styl'
  ],
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#3B8070' },
  /*
  ** Build configuration
  */
  build: {
    vendor: [
      '~/plugins/vuetify.js'
    ],
    extractCSS: true,
    /*
    ** Run ESLint on save
    */
    extend (config, ctx) {
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    },
    plugins: [
      new webpack.ProvidePlugin({
        _: "lodash"
      })
    ]
  },
  modules: [
    '@nuxtjs/dotenv',
    '@nuxtjs/axios'
  ],
  generate: {
    dir: './nuxt_dist'
  },
  env: {
    API_ORIGIN: "/api/v1/",
    API_ORIGIN_DEV_CLIENT: "http://127.0.0.1/api/v1/",
    API_ORIGIN_DEV_SERVER: "http://nginx/api/v1/",
    IMAGE_ORIGIN: "/api/storage",
    IMAGE_ORIGIN_DEV: "http://127.0.0.1/api/storage",
    API_DUMMY_USER_NAME: dotenv.API_DUMMY_USER_NAME,
    API_DUMMY_USER_EMAIL: dotenv.API_DUMMY_USER_EMAIL,
    API_DUMMY_USER_PW: dotenv.API_DUMMY_USER_PW,
    UPLOAD_FILESIZE_MAX: dotenv.UPLOAD_FILESIZE_MAX,
  },
}
