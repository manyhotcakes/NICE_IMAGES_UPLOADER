<template>
  <div>
    <v-btn class="ml-0" :disabled="disabled" color="white" @click="onFocus">ファイル選択</v-btn>
    <input type="file" accept="image/*" :multiple="false" :disabled="disabled"
           ref="fileInput" @change="onFileChange" style="display:none;">
  </div>
</template>


<script>
  export default {
    props: [
      'disabled'
    ],
    mounted () {
      // this.queryAndIndeterminate()
    },

    beforeDestroy () {
      clearInterval(this.interval)
    },

    methods: {
      onFocus () {
        if (!this.disabled) {
          this.$refs.fileInput.click()
        }
      },
      onFileChange ($event) {
        const target = $event.target
        const files = target.files
        this.$emit('change', files[0])
      }
    }
  }
</script>
