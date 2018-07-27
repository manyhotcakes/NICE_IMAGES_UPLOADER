<template>
<v-dialog v-model="isOpen" max-width="500px">
       <v-card>
         <v-card-text class="pa-0">
           <v-list>
             <template v-for="(item, index) in dialogItems">
               <v-list-tile @click="onMenuClick(item.id)" :disabled="item.disabled">
                 <v-list-tile-content>
                   <v-list-tile-title class="text-xs-center" v-html="item.label"/>
                 </v-list-tile-content>
               </v-list-tile>
               <v-divider v-if="index !== dialogItems.length - 1"/>
             </template>
           </v-list>
         </v-card-text>
       </v-card>
</v-dialog>
</template>

<script>
export default {
  props: [
    'targetIndex',
    'targetItem'
  ],
  data: () => ({
    isOpen: false,
    dialogItems: [
      {
        id: 'download',
        label: '画像ダウンロード',
        disabled: false
      },
      {
        id: 'delete',
        label: '画像削除',
        disabled: false
      },
      {
        id: 'rename',
        label: '名称変更',
        disabled: true
      },
      {
        id: 'cancel',
        label: 'キャンセル',
        disabled: false
      }
    ]
  }),
  methods: {
    async onMenuClick (method) {
      switch (method) {
        case 'download':
          const ext = (this.targetItem.path.match(/(\..+?)$/) || ['']).shift()
          const a = document.createElement('a')
          a.setAttribute('download', this.targetItem.name + ext)
          a.href = this.targetItem.url
          a.dispatchEvent(new MouseEvent('click'))
          break
        case 'delete':
          if (confirm(`${this.targetItem.name}を削除してよろしいですか`)) {
            await this.deleteImage()
            this.close()
          }
          break
        case 'rename':
          break
        case 'cancel':
          this.close()
          break
      }
    },
    close () {
      this.isOpen = false
    },
    open () {
      this.isOpen = true
    },
    async deleteImage () {
      const {data: {success: result}} = await this.$axios({
        method: 'delete',
        url: `/images/${this.targetItem.id}`
      })
      console.log(`result: ${result}`)
      this.$store.commit('imagelistUpdateFlg', result)
    }
  }
}
</script>
