<template>
  <v-app>
    <v-toolbar dark color="primary">
      <a @click="$router.go(-1)" v-if="toolbarBack">
        <v-icon color="white">arrow_back_ios</v-icon>
      </a>
      <v-toolbar-title class="white--text" v-text="toolbarTitle"></v-toolbar-title>
    </v-toolbar>
    <v-content>
      <!-- <v-container> -->
        <nuxt />
      <!-- </v-container> -->
    </v-content>
    <v-footer id="footer" :fixed="true" height="auto" app class="footer pt-4" :style="footerStyle">
      <uploader/>
    </v-footer>
    <v-btn class="close" fab medium color="orange" @click="onButtonClick" :style="buttonStyle">
      <v-icon v-if="isDisplay" color="white">close</v-icon>
      <v-icon v-else color="white">cloud_upload</v-icon>
    </v-btn>
  </v-app>
</template>

<style lang="scss" scoped>
.footer {
  z-index: 1000;
  box-shadow: 0px -3px 5px -1px rgba(0, 0, 0, .2),
    0px -6px 10px 0px rgba(0, 0, 0, .14),
    0px -1px 18px 0px rgba(0, 0, 0, .12);
}
.close {
  z-index: 1001;
  position: fixed;
  bottom: 5px;
  right: 5px;
}
</style>

<script>
import { mapGetters } from 'vuex'
import Uploader from '~/components/Uploader.vue'
export default {
  components: {
    Uploader
  },
  methods: {
    onButtonClick () {
      this.$store.commit('toggleSidebar')
    }
  },
  head () {
    return {
      title: 'NiceImages'
    }
  },
  computed: {
    ...mapGetters({
      toolbarBack: 'toolbar/back',
      toolbarTitle: 'toolbar/title',
      isDisplay: 'sidebar'
    }),
    footerStyle () {
      const style = []
      if (!this.isDisplay) {
        style.push({
          transform: 'translateY(300px)'
          // bottom: '-300px'
        })
      }
      return style
    },
    buttonStyle () {
      const style = []
      if (this.isDisplay) {
        style.push({
          bottom: `${document.querySelector('#footer').offsetHeight}px`
        })
        style.push({
          transform: 'translateY(50%)'
        })
      }
      return style
    }
  }
}
</script>
