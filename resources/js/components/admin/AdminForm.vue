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
    <el-form-item :label="$t('admin.common.email')">
      <el-input
          v-model="form.email"
          maxlength="255"
          show-word-limit
      ></el-input>
    </el-form-item>
    <el-form-item :label="$t('admin.common.phone')">
      <el-input
          v-model="form.phone"
          maxlength="255"
          show-word-limit
      ></el-input>
    </el-form-item>
    <el-form-item :label="$t('admin.common.role')">
      <div>
        <el-select
            v-model="role"
            :placeholder="$t('admin.common.select_role')"
            clearable
            filterable
            @change="handleSelectRole"
        >
          <el-option
              v-for="role in adminRoles"
              :key="role.id"
              :label="role.name"
              :value="role.id"

          >
          </el-option>
        </el-select>
        <div class="list-tags">
          <el-tag
              v-for="role in roles"
              :key="role.id"
              closable
              type="primary"
              @close="handleRemoveRole(role)"
          >
            {{ role.name }}
          </el-tag>
        </div>
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
    adminRoles: {
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
      roles: [],
      role: '',
    };
  },
  created() {
    this.initForm(this.target);
    this.initImage();
    this.initRole();
  },
  watch: {
    target(data) {
      this.initForm(data);
      this.initImage();
      this.initRole();
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
    initRole() {
      this.roles = [];

      if (!this._.isEmpty(this.form.roles)) {
        this.roles = this.form.roles;
      }
    },
    handleSelectImage(image) {
      if (!this._.isEmpty(image)) {
        this.form.image = image;
      }
    },
    handleSelectRole() {
      const role = this._.find(this.adminRoles, role => role.id.toString() === this.role.toString());
      const roleExists = this._.find(this.roles, role => role.id.toString() === this.role.toString());

      if (!this._.isEmpty(role) && this._.isEmpty(roleExists)) {
        this.roles.push(role);
      }

      this.role = '';
    },
    handleRemoveRole(role) {
      this.roles.splice(this._.findIndex(this.roles, role), 1);
    },
    async handleSubmit() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        this.form.role_ids = [];
        this._.forEach(this.roles, role => {
          this.form.role_ids.push(role.id);
        });
        const uri = (this.mode === 'edit')
            ? this.route('admin.ajax_update_admin', {admin: this.form.id})
            : this.route('admin.ajax_create_admin');
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
