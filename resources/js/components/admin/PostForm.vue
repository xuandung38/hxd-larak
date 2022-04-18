<template>
  <div>
    <el-form
        ref="postForm"
        :model="form"
        label-position="left"
        label-width="120px"
    >
      <el-form-item :label="$t('admin.common.category')">
        <el-select
            v-model="form.blog_category_id"
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
        ></el-input>
      </el-form-item>
      <el-form-item :label="$t('admin.common.description')">
        <el-input
            v-model="form.description"
            :rows="5"
            type="textarea">
        </el-input>
      </el-form-item>
      <el-form-item :label="$t('admin.common.content')">
        <vue-editor
            id="edit_msg"
            v-model="form.content"
        >
        </vue-editor>
      </el-form-item>
      <el-form-item :label="$t('admin.common.custom_page')">
        <el-switch
            v-model="form.is_custom_page"
            active-color="#13ce66"
            inactive-color="#ff4949">
        </el-switch>
      </el-form-item>
      <el-form-item label="Hình ảnh">
        <ImageUploader
            :on-select="handleSelectImage"
            :source="form.image"
        />
      </el-form-item>
      <el-form-item>
        <el-button
            type="success"
            @click="handleSubmit"
        >
          {{ $t('admin.common.save') }}
        </el-button>
        <el-button @click="handleCancel">
          {{ $t('admin.common.cancel') }}
        </el-button>
      </el-form-item>
    </el-form>
  </div>

</template>
<script>
import ImageUploader from "../common/ImageUploader";
import {VueEditor} from "vue2-editor";

export default {
  components: {ImageUploader, VueEditor},
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
    admin: {
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
      isSearching: false,
      categories: [],
    }
  },
  created() {
    this.initForm(this.target);
    this.initImage();
  },
  mounted() {
    this.initCategory();
  },
  watch: {
    target(updatedRecord) {
      this.initForm(updatedRecord);
      this.initImage();
      this.initCategory();
    },
    image(image) {
      this.updateImage(image);
    },
  },
  methods: {
    initForm(data) {
      if (this._.isEmpty(data)) {
        this.form = {
          image: '',
          is_custom_page: false,
        };
        this.mode = 'create';
      } else {
        this.form = this._.clone(data);
        this.form.is_custom_page = (this.form.is_custom_page === 1 || this.form.is_custom_page === true);
        this.mode = 'edit';
      }
    },
    initImage() {
      if (this._.isEmpty(this.form.image)) {
        this.form.image = '/images/no-img.jpg';
      }
    },
    initCategory() {
      this.categories = [];
      if (!this._.isEmpty(this.form.category)) {
        this.categories.push(this.form.category);
      }
    },
    handleSelectImage(image) {
      this.form.image = image;
    },
    async handleSearchCategory(search) {
      if (this._.isEmpty(search)) {
        return;
      }
      const params = {
        search,
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
            ? this.route('admin.ajax_update_post', {post: this.form.id})
            : this.route('admin.ajax_create_post');
        const response = (this.mode === 'edit')
            ? await this.Request.patch(uri, this.form)
            : await this.Request.post(uri, this.form);
        this.onSuccess(response.data, this.mode);
        this.$refs['postForm'].resetFields();
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
      this.$refs['postForm'].resetFields();
      this.onCancel();
    },
  }
}
</script>
