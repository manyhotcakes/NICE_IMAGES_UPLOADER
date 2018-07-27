import Vue from 'vue'
Vue.mixin({
  // isDevの共通化
  data: function () {
    return {
      get isDev () {
        return process.env.NODE_ENV === 'development'
      }
    }
  }
  // // titleの共通化
  // mounted () {
  //   let { title } = this.$options
  //   if (title) {
  //     title = typeof title === 'function' ? title.call(this) : title
  //     this.$store.commit('title', title)
  //   }
  // }
})
