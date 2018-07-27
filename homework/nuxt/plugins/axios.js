export default function ({ $axios, redirect, store, app }) {
  $axios.onRequest(config => {
    // config.timeout = 3000
    config.baseURL = app.context.isDev
      ? (process.server
        ? process.env.API_ORIGIN_DEV_SERVER
        : process.env.API_ORIGIN_DEV_CLIENT
      )
      : process.env.API_ORIGIN
  })
  $axios.onError(error => {
    store.dispatch('error/setError', error)
  })
}
