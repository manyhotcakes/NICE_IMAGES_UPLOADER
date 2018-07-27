export const state = () => ({
  back: false,
  title: ''
})

export const mutations = {
  back (state, bool) {
    state.back = bool
  },
  title (state, text) {
    state.title = text
  }
}

export const getters = {
  back: (state) => (state.back),
  title: (state) => (state.title)
}
