<template>
  <div class="l-wrap">
    <div style="overflow: hidden" class="l-image">
      <div class="l-image_in image" v-if="item" :style="imageStyle">
        <div class="image_content">
          <img class="" :src="item.url"/>
        </div>
      </div>
    </div>
    <div>
      <v-list>
        <template v-for="(item, index) in list">
          <v-list-tile class="py-1">
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title"/>
              <v-list-tile-sub-title v-text="item.value || '-'"/>
            </v-list-tile-content>
          </v-list-tile>
        </template>
        <v-divider/>
      </v-list>
      <v-layout row wrap>
        <v-spacer/>
        <v-btn>画像ダウンロード</v-btn>
        <v-btn>画像削除</v-btn>
        <v-btn disabled>名称変更</v-btn>
      </v-layout>
      <!-- <v-layout>
        <v-spacer/>
        <v-flex>
          <v-btn>画像ダウンロード</v-btn>
        </v-flex>
        <v-flex>
          <v-btn>画像削除</v-btn>
        </v-flex>
        <v-flex>
          <v-btn disabled>名称変更</v-btn>
        </v-flex>
      </v-layout> -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
.l-wrap {
  width: 100%;
}
.l-image {
  height: 40vh;
}
.l-image_in {
  height: 100%;
  position: relative;
}
.image {
  background-size: cover;
  background-position: center;
  z-index: 0;
  text-align: center;
  &::before {
    content: '';
    position: absolute;
    top: -7px;
    left: -7px;
    right: -7px;
    bottom: -7px;

    background: inherit;
    filter: grayscale(100%) blur(7px) brightness(50%);
    z-index: -1;
  }
  &_content {
    position: static;
    width: 100%;
    height: 100%;
    vertical-align: middle;
    object-fit: contain;
    & > img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
  }
}
</style>

<script>
export default {
  fetch ({store, params}) {
    store.commit('toolbar/back', true)
    store.commit('toolbar/title', '')
  },
  validate ({ params }) {
    // 数値でなければならない
    return /^\d+$/.test(params.id)
  },
  data: () => ({
    item: null,
    list: [],
    whitelist: {
      name: {label: '名前', order: 0},
      author_id: {label: '投稿者ID', order: 3},
      author_ip: {label: '投稿者IP', order: 4},
      created_at: {label: '投稿日時', order: 1},
      updated_at: {label: '更新日時', order: 2}
    }
  }),
  async created () {
    this.item = await this.getItem()
    this.$store.commit('title', this.item.name)
  },
  methods: {
    async getItem () {
      if (this.$route.params.id) {
        const id = this.$route.params.id
        const imageBaseUrl = this.isDev ? process.env.IMAGE_ORIGIN_DEV : process.env.IMAGE_ORIGIN
        const {data: item} = await this.$axios.get(`/images/${id}`)
        item.url = `${imageBaseUrl}${item.path}`
        this.$store.commit('toolbar/title', item.name)

        const list = []
        // 取得したデータのうち、whitelistで許可されているもののみ、listに追加する
        _.each(item, (v, k) => {
          if (this.whitelist[k]) {
            list.push({
              title: this.whitelist[k].label,
              value: v,
              order: this.whitelist[k].order
            })
          }
        })
        this.list = _.sortBy(list, 'order')
        return item
      }
    }
  },
  computed: {
    imageStyle () {
      console.log(this.item.url)
      return `background-image: url(${this.item.url})`
    }
  }
}
</script>
