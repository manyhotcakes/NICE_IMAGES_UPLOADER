<template>
  <div class="image">
    <v-btn v-if="isDispButon" fab small color="black" class="image_more" @click.stop="onClick">
      <v-icon color="white">more_horiz</v-icon>
    </v-btn>
    <router-link :to="{ name: 'detail-id', params: { id } }">
      <img src="~/static/blank_10x10.png" class="image_dummy">
      <img :src="src" class="image_body">
      <div class="name" v-text="name"/>
    </router-link>
  </div>
</template>

<style lang="scss" scoped>
.image {
  width: 100%;
  position: relative;
  &_dummy {
    width: 100%;
    height: auto;
    vertical-align: middle;
  }
  &_more {
    z-index: 10;
    position: absolute;
    right: 0;
    top: 0;
  }
}
.image_body {
  position: absolute;
  vertical-align: middle;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.name {
  position: absolute;
  bottom: 0;
  background-color: rgba(0,0,0,0.7);
  width: 100%;
  text-align: right;
  color: white;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
</style>


<script>
  export default {
    props: {
      index: Number,
      src: String,
      name: String,
      isDispButon: {
        type: Boolean,
        default: false
      },
      id: Number
    },
    methods: {
      onClick () {
        this.$emit('open-menu', this.index)
      }
    }
  }
</script>
