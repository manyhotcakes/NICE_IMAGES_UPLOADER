export const state = () => ({
  sidebar: false,
  imagelistUpdateFlg: false,
  title: ''
})

export const mutations = {
  toggleSidebar (state) {
    state.sidebar = !state.sidebar
  },
  imagelistUpdateFlg (state, bool) {
    state.imagelistUpdateFlg = !!bool
  },
  title (state, text) {
    state.title = text
  }
}

export const getters = {
  imagelistUpdateFlg: (state) => (state.imagelistUpdateFlg),
  sidebar: (state) => (state.sidebar),
  title: (state) => (state.title)
}
