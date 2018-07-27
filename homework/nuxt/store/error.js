export const state = () => ({
  code: null,
  message: null
})

export const mutations = {
  code (state, code) {
    state.code = code
  },
  message (state, text) {
    state.message = text
  },
  reset (state) {
    state.code = null
    state.message = null
  }
}

export const getters = {
  code: state => (state.code),
  message: state => (state.message)
}

export const actions = {
  getErrorOverviewAndFlush: context => {
    const code = context.getters('code')
    const message = context.getters('message')
    context.commit('reset')
    return `${code}: ${message}`
  },
  setError: (context, error) => {
    console.log('setError', error)
    const code = parseInt(error.response && error.response.status)
    const message = error.message
    context.commit('code', code)
    context.commit('message', message)
  }
}
