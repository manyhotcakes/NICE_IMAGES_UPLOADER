<template>
  <v-container>
    <v-layout column justify-center align-center>
      <v-container fluid grid-list-xs>
        <image-list :items="items"/>
        <v-layout row wrap>
        </v-layout>
      </v-container>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import ImageList from '~/components/ImageList.vue'
export default {
  components: {
    ImageList
  },
  data: () => ({
    items: []
  }),
  fetch ({store, params}) {
    store.commit('toolbar/back', false)
    store.commit('toolbar/title', 'NiceImages')
  },
  async created () {
    this.items = await this.getList()
  },
  // asyncData: async function (app) {
  //   const {data: items} = await app.$axios.get('/images')
  //   console.log(items)
  //   return {
  //     items
  //   }
  // },
  watch: {
    /* broadcast がわり。imagelistUpdateFlgがtrueになれば、表示画像リストの更新を行う */
    async imagelistUpdateFlg () {
      if (this.imagelistUpdateFlg) {
        this.items = await this.getList()
        window.scrollTo({top: 0, behavior: 'smooth'})
      }
    }
  },
  methods: {
    async getList () {
      const imageBaseUrl = this.isDev ? process.env.IMAGE_ORIGIN_DEV : process.env.IMAGE_ORIGIN
      const {data: items} = await this.$axios.get('/images')
      _.map(items, (v) => {
        v.url = `${imageBaseUrl}${v.path}`
      })
      this.$store.commit('imagelistUpdateFlg', false)
      return items
    }
  },
  computed: {
    ...mapGetters({
      imagelistUpdateFlg: 'imagelistUpdateFlg'
    })
  }
}
</script>
