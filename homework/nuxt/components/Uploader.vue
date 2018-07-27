<template>
  <v-container fluid>
    <v-form>
      <v-layout row wrap>
        <v-flex xs12 sm3 class="text-xs-left text-sm-center">
          <file-input @change="onChange" :disabled="uploading"/>
        </v-flex>
        <v-flex xs12 sm6 class="text-sm-center">
          <v-text-field
          v-validate="'required|max:20'"
          v-model="name"
          :counter="20"
          :error-messages="errors.collect('name')"
          label="Name"
          :disabled="!file || uploading"
          required
          data-vv-name="name"/>
        </v-flex>
        <v-flex xs12 sm3 class="text-xs-right text-sm-center">
          <v-btn
            :disabled="!file || uploading"
            color="blue"
            class="white--text mr-0"
            @click.native="submit"
          >
            Upload
            <v-icon right dark>cloud_upload</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-form>
    <div>
      <v-progress-linear
        v-show="uploading"
        :indeterminate="true"
        height="4"
      />
    </div>
  </v-container>
</template>

<style scoped>
.l-wrap {
  width: 80%;
  margin: auto;
  padding: 20px 0;
}
</style>

<script>
// import moment from 'moment'
import FileInput from '~/components/FileInput.vue'
export default {
  $_veeValidate: {
    validator: 'new'
  },
  components: {
    FileInput
  },
  data: () => ({
    file: null,
    uploading: false,
    name: '',
    dictionary: {
      custom: {
        name: {
          required: '必須フィールドです',
          max: '名前は20文字以内で設定してください'
        }
      }
    }
  }),
  mounted () {
    this.$validator.localize('ja', this.dictionary)
  },
  methods: {
    async submit () {
      const bodyFormData = new FormData()
      bodyFormData.set('file', this.file)
      bodyFormData.set('name', this.name)
      this.$validator.validateAll()
      this.uploading = true
      const {data: {success: result}} = await this.$axios({
        method: 'post',
        url: '/images',
        config: {
          headers: {'Content-Type': 'multipart/form-data'}
        },
        data: bodyFormData
      })
      console.log(`upload: ${result}`)
      this.uploading = false
      this.formClear()
      this.$store.commit('imagelistUpdateFlg', result)
    },
    formClear () {
      this.file = null
      this.name = null
    },
    onChange (file) {
      if (!file) {
        this.formClear()
      } else {
        this.file = file
        if (!this.name) {
          this.name = file.name.replace(/\..*$/, '')
        }
      }
    }
  }
}
</script>
