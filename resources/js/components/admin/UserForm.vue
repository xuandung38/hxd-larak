<template>
  <el-form
      ref="form"
      :model="form"
      label-position="left"
      label-width="120px"
  >
    <el-form-item :label="$t('admin.common.name')">
      <el-input
          v-model="form.name"
          maxlength="255"
          show-word-limit
      ></el-input>
    </el-form-item>
    <el-form-item :label="$t('admin.common.username')">
      <el-input
          v-model="form.username"
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
    <el-form-item label="Ngày sinh">
      <el-date-picker
          v-model="form.birth_date"
          type="date"
          placeholder="Chọn một ngày"
          format="yyyy/MM/dd"
          value-format="yyyy-MM-dd"
      >
      </el-date-picker>
    </el-form-item>
    <el-form-item :label="$t('admin.common.phone')">
      <el-input
          v-model="form.phone"
          maxlength="255"
          show-word-limit
      ></el-input>
    </el-form-item>
    <el-form-item label="Phòng ban">
      <div>
        <el-select
            v-model="form.department_id"
            :placeholder="$t('admin.common.select_role')"
            clearable
            filterable
        >
          <el-option
              v-for="department in userDepartments"
              :key="department.id"
              :label="department.name"
              :value="department.id"

          >
          </el-option>
        </el-select>
      </div>
    </el-form-item>
    <el-form-item :label="$t('admin.common.role')">
      <div>
        <el-select
            v-model="form.position_id"
            :placeholder="$t('admin.common.select_role')"
            clearable
            filterable
        >
          <el-option
              v-for="position in userPositions"
              :key="position.id"
              :label="position.name"
              :value="position.id"

          >
          </el-option>
        </el-select>
      </div>
    </el-form-item>
    <el-form-item :label="$t('admin.common.image')">
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
      <el-button
          @click="onCancel"
      >
        {{ $t('admin.common.cancel') }}
      </el-button>
    </el-form-item>
  </el-form>
</template>
<script>
import ImageUploader from "../common/ImageUploader";

export default {
  components: {ImageUploader},
  props: {
    target: {
      Type: Object,
      default() {
        return {};
      },
    },
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
    userDepartments: {
      type: Array,
      default() {
        return [];
      }
    },
    userPositions: {
      type: Array,
      default() {
        return [];
      }
    },
  },
  data() {
    return {
      form: {},
      mode: '',
    };
  },
  created() {
    this.initForm(this.target);
    this.initImage();
  },
  watch: {
    target(data) {
      this.initForm(data);
      this.initImage();
    },
  },
  methods: {
    initForm(data) {
      this.form = this._.clone(data);
      this.mode = this._.isEmpty(data) ? 'create' : 'edit';
    },
    initImage() {
      if (this._.isEmpty(this.form.image)) {
        this.form.image = '/images/no-img.jpg';
      }
    },

    handleSelectImage(image) {
      if (!this._.isEmpty(image)) {
        this.form.image = image;
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
        const uri = (this.mode === 'edit')
            ? this.route('admin.ajax_update_user', {user: this.form.id})
            : this.route('admin.ajax_create_user');
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
    },
  },
}
</script>
