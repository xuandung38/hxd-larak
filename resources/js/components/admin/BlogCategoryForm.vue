<template>
  <el-form
      ref="form"
      :model="form"
      label-position="left"
      label-width="120px"
  >
    <el-form-item :label="$t('admin.common.parent')">
      <el-select
          v-model="form.parent_id"
          :loading="isSearching"
          :loading-text="$t('admin.common.loading')"
          :no-data-text="$t('admin.common.no_data_text')"
          :no-match-text="$t('admin.common.no_match_text')"
          :placeholder="$t('admin.message.enter_id_or_name_to_search')"
          :remote-method="handleSearchCategory"
          clearable
          filterable
          remote
          reserve-keyword
      >
        <el-option
            v-for="category in categories"
            :key="category.id"
            :label="category.name"
            :value="category.id">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item :label="$t('admin.common.name')">
      <el-input
          v-model="form.name"
          maxlength="255"
          show-word-limit
      />
    </el-form-item>
    <el-form-item :label="$t('admin.common.description')">
      <el-input
          v-model="form.description"
          type="textarea"
      />
    </el-form-item>
    <el-form-item label="Hình ảnh">
      <ImageUploader
          :on-select="handleSelectImage"
          :source="form.image"
      />
    </el-form-item>
    <div class="submit-area">
      <el-button
          type="success"
          @click="handleSubmit"
      >
        {{ $t('admin.common.save') }}
      </el-button>
      <el-button @click="handleCancel">
        {{ $t('admin.common.cancel') }}
      </el-button>
    </div>
  </el-form>
</template>
<script>
import ImageUploader from "../common/ImageUploader";

export default {
  components: {ImageUploader},
  props: {
    onSuccess: {
      type: Function,
      default() {
        return null;
      }
    },
    onCancel: {
      type: Function,
      default() {
        return null;
      }
    },
    target: {
      type: Object,
      default() {
        return {};
      }
    },
  },
  data() {
    return {
      form: {},
      mode: '',
      categories: [],
      isSearching: false,
    }
  },
  mounted() {
    this.initForm(this.target);
    this.initCategory();
    this.initImages();
  },
  watch: {
    target: function (data) {
      this.initForm(data);
      this.initCategory();
      this.initImages();
    },
  },
  methods: {
    initForm(data) {
      if (this._.isEmpty(data)) {
        this.form = {
          image: '/images/no-img.jpg',
        };
        this.mode = 'create';
      } else {
        this.form = this._.clone(data);
        this.mode = 'edit';
      }
    },
    initCategory() {
      this.categories = [];
      if (!this._.isEmpty(this.form.parent_category)) {
        this.categories.push(this.form.parent_category);
      }
    },
    handleSelectImage(image) {
      if (!this._.isEmpty(image)) {
        this.form.image = image;
      }
    },
    initImages() {
      if (this._.isEmpty(this.form.image)) {
        this.form.image = '/images/no-img.jpg';
      }
    },
    async handleSearchCategory(search) {
      if (this._.isEmpty(search)) {
        return;
      }
      const params = {
        search,
        except_id: this.form.id,
      };
      this.isSearching = true;
      try {
        const uri = this.route('admin.ajax_search_blog_category', params);
        const response = await this.Request.get(uri);
        this.categories = response.data.data;
      } catch (e) {
        console.log(e); // eslint-disable-line
        const errorMessages = this.Request.errors(e.response);
        this.$notify({
          type: 'error',
          title: this.$t('admin.common.error'),
          message: this._.isEmpty(errorMessages) ? this.$t('admin.common.unknown_error') : errorMessages[0],
        });
      }
      this.isSearching = false;

    },
    async handleSubmit() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {

        const uri = (this.mode === 'edit')
            ? this.route('admin.ajax_update_blog_category', {category: this.form.id})
            : this.route('admin.ajax_create_blog_category');
        const response = (this.mode === 'edit')
            ? await this.Request.patch(uri, this.form)
            : await this.Request.post(uri, this.form);
        this.onSuccess(response.data, this.mode);
        this.resetForm();
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: (this.mode === 'edit') ? this.$t('admin.common.updated') : this.$t('admin.common.created'),
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
    handleCancel() {
      this.resetForm();
      this.onCancel();
    },
    resetForm() {
      this.$refs['form'].resetFields();
    }
  }
}
</script>
