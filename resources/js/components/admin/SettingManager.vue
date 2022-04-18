<template>
  <el-container class="manager-screen">
    <el-main>
      <el-form
          ref="form"
          :model="form"
          class="mr-clear form-dialog"
          label-position="left"
          label-width="175px"
      >
        <el-tabs type="border-card">
          <el-tab-pane label="Thông tin chung">
            <el-form-item :label="$t('admin.common.site_name')">
              <el-input
                  v-model="form.name"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.address')">
              <el-input
                  v-model="form.address"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.phone')">
              <el-input
                  v-model="form.phone"
                  maxlength="15"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.hotline')">
              <el-input
                  v-model="form.hotline"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.email')">
              <el-input
                  v-model="form.email"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>

            <el-form-item :label="$t('admin.common.color')">
              <el-color-picker v-model="form.color" show-alpha></el-color-picker>
            </el-form-item>

            <el-form-item label="Logo">
              <ImageUploader
                  :on-select="onSelectLogo"
                  :preview-image="false"
                  :source="form.logo"
              />
            </el-form-item>

            <el-form-item :label="$t('admin.common.title')">
              <el-input
                  v-model="form.title"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.keyword')">
              <el-input
                  v-model="form.keyword"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.description')">
              <el-input
                  v-model="form.description"
                  maxlength="255"
                  show-word-limit
              ></el-input>
            </el-form-item>
            <el-form-item :label="$t('admin.common.thumbnail')">
              <ImageUploader
                  :on-select="onSelectThumbnail"
                  :preview-image="false"
                  :source="form.thumbnail"
              />
            </el-form-item>

            <el-form-item label="GG Analytic">
              <el-input
                  v-model="form.gg_analytic_id"
              ></el-input>
            </el-form-item>

            <el-form-item label="Facebook">
              <el-input v-model="form.facebook"></el-input>
            </el-form-item>

            <el-form-item label="Twitter">
              <el-input v-model="form.twitter"></el-input>
            </el-form-item>

            <el-form-item label="Youtube">
              <el-input v-model="form.youtube"></el-input>
            </el-form-item>

            <el-form-item label="Telegram">
              <el-input v-model="form.telegram"></el-input>
            </el-form-item>

            <el-form-item label="Thông báo trang chủ">
              <vue-editor
                  id="notification"
                  v-model="form.notification"
              >
              </vue-editor>
            </el-form-item>
          </el-tab-pane>
          <el-tab-pane label="Slider">
            <div class="row">
              <div class="col-sm-12 mr-clear">
                <ImageUploader
                    :on-select="onSelectSlide"
                    :preview-image="false"
                    :source="'/images/add-image.png'"
                />
              </div>
              <div class="col-sm-12 mr-clear">
                <div
                    v-for="(slide, i) in slider"
                    :key="i"
                    class="image-item"
                >
                  <el-image :src="slide.image" class="img-rounded">
                    <div slot="placeholder"><i class="el-icon-loading"></i></div>
                    <div slot="error"><img alt="" src="/images/no-img.jpg"/></div>
                  </el-image>
                  <el-input
                      v-model="slide.link"
                      placeholder="Link"
                  ></el-input>
                  <el-button
                      circle
                      class="image-button"
                      icon="el-icon-delete"
                      plain
                      size="small"
                      title="Xóa ảnh"
                      type="danger"
                      @click="handleRemoveSlide(slider, i)"
                  />

                </div>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </el-form>
      <div class="row text-center">
        <el-button
            type="success"
            @click="handleSubmit"
        >{{ $t('admin.common.save') }}
        </el-button>
      </div>
    </el-main>
  </el-container>
</template>
<script>
import ImageUploader from "../common/ImageUploader";
import {VueEditor} from "vue2-editor";

export default {
  components: {ImageUploader, VueEditor},
  props: {
    user: {
      Type: Object,
      default() {
        return {};
      },
    },
    setting: {
      Type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      form: this._.clone(this.setting),
      slider: [],
    };
  },
  created() {
    this.initImages();
  },
  methods: {
    onSelectLogo(payload) {
      this.form.logo = payload
    },
    onSelectSlide(payload) {
      this.slider.push({
        image: payload,
        link: '',
      });
    },
    onSelectThumbnail(payload) {
      this.form.thumbnail = payload
    },
    handleRemoveSlide(slider, index) {
      slider.splice(index, 1);
    },
    initImages() {
      this.slider = [];
      if (!this._.isEmpty(this.form.slider)) {
        this.slider = this.Helper.convertJson(this.form.slider);
      }
      if (this._.isEmpty(this.form.logo)) {
        this.form.logo = '/images/no-img.jpg';
      }
      if (this._.isEmpty(this.form.thumbnail)) {
        this.form.thumbnail = '/images/no-img.jpg';
      }
    },
    async handleSubmit() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        this.form.slider = this.slider;
        const uri = this.route('admin.ajax_update_setting');
        await this.Request.patch(uri, this.form);
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.common.updated'),
        });
      } catch (e) {
        console.log(e); // eslint-disable-line
        const errorMessages = this.Request.errors(e.response);
        this.$notify({
          type: 'error',
          title: this.$t('admin.common.error'),
          message: this._.isEmpty(errorMessages) ? this.$t('admin.common.unknown_error') : errorMessages[0],
        });
      }
      loading.close();
    },

  },

}
</script>
