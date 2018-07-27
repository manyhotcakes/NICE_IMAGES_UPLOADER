<template>
  <v-layout row wrap>
    <v-flex v-for="v,k in items" :key="k" xs4 sm3>
      <image-list-item :isDispButon="true" :index="k" :src="v.url" :name="v.name" :id="v.id" @open-menu="onOpenMenu"/>
    </v-flex>
    <image-list-dialog
      :targetItem="targetItem"
      :targetIndex="targetIndex"
      ref="dialog"/>
  </v-layout>
</template>

<script>
import ImageListItem from '~/components/ImageListItem.vue'
import ImageListDialog from '~/components/ImageListDialog.vue'
export default {
  props: [
    'items'
  ],
  components: {
    ImageListItem,
    ImageListDialog
  },
  created () {
  },
  data () {
    return {
      targetIndex: null,
      targetItem: null
    }
  },
  methods: {
    onOpenMenu (index) {
      this.targetItem = this.items[index]
      this.targetIndex = index
      this.$refs.dialog.open()
    }
  }
}
</script>
