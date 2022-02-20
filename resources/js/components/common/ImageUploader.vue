<template>
  <div class="image-uploader">
    <div
        :id="previewerId"
        class="image-uploader__previewer"
        @click="onClickSelectImage"
    >
    </div>
    <div class="image-uploader__selector">
      <input
          :id="selectorId"
          accept=".png,.jpg,.jpeg"
          class="file"
          type="file"
          @change="onSelectImage"
      >
    </div>
  </div>
</template>
<script>
export default {
  props: {
    source: {
      Type: String,
      default: '/images/no-img.jpg',
    },
    onSelect: {
      Type: Function,
      default() {
        return null;
      },
    },
    previewImage: {
      Type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      src: this._.clone(this.source),
      selectorId: 'img_uploader_' + this.Helper.randomString(10),
      previewerId: 'img_previewer_' + this.Helper.randomString(10),
    }
  },
  mounted() {
    this.initImage(this.src)
  },
  watch: {
    source(payload) {
      this.src = payload;
      this.initImage(this.src)
    }
  },
  methods: {
    initImage(url) {
      const image = new window.Image()
      image.src = url || '/images/no-img.jpg'
      const that = this
      image.onload = () => {
        that.displayImage(image)
      };
    },
    onClickSelectImage() {
      document.getElementById(this.selectorId).click()
    },
    onSelectImage() {
      const file = document.getElementById(this.selectorId).files[0];

      if (this._.isUndefined(file) || this._.isNull(file)) {
        return
      }

      if (file.size > this.attachmentSizeLimit) {
        this.$notify({
          type: 'error',
          title: 'Thất bại',
          message: 'Dung luợng ảnh quá lớn, vượt quá 4mb'
        });
        return
      }

      if (file.type !== 'image/jpeg'
          && file.type !== 'image/jpg'
          && file.type !== 'image/png'
      ) {
        this.$notify({
          type: 'error',
          title: 'Thất bại',
          message: 'Định dạng ảnh không hợp lệ'
        });
      }

      const reader = new FileReader()
      const that = this

      reader.onload = function (e) {
        const image = new window.Image()
        image.src = e.target.result
        image.onload = () => {
          if (that.previewImage) {
            that.displayImage(image)
          }
          that.uploadImage()
        };
      }
      reader.readAsDataURL(file)
    },
    displayImage(image) {
      const imagePreviewer = document.getElementById(this.previewerId)
      imagePreviewer.innerHTML = ''
      imagePreviewer.append(image)
    },
    async uploadImage() {
      try {
        const file = document.getElementById(this.selectorId).files[0];
        let formData = new FormData();
        formData.append('file', file);
        formData.append('mime', file.type);
        const uploadResponse = await this.Request.upload(this.route('file-manager.anonymous_upload'), formData);
        this.onSelect(uploadResponse.data.url)
      } catch (e) {
        console.log(e)
      }
    },

  }
}
</script>
