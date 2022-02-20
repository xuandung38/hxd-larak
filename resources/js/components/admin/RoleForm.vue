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
      />
    </el-form-item>
    <el-form-item label="Guard">
      <el-select
          v-model="form.guard"
      >
        <el-option
            label="Admin"
            value="admin">
        </el-option>
        <el-option
            label="User"
            value="user">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item label="Level">
      <el-input
          v-model="form.level"
      />
    </el-form-item>
    <el-form-item label="Quyền">
      <el-transfer
          v-model="selectedPermissions"
          :data="permissionsDataSet"
          :titles="['Tất cả', 'Đã chọn']">
      </el-transfer>
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
export default {
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
    permissions: {
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
      selectedPermissions: [],
      permissionsDataSet: [],
    }
  },
  mounted() {
    this.initForm(this.target);
    this.initPermissions();
    this.initSelectedPermissions();
  },
  watch: {
    target: function (data) {
      this.initForm(data);
      this.initSelectedPermissions();
    },
  },
  methods: {
    initForm(data) {
      if (this._.isEmpty(data)) {
        this.form = {};
        this.mode = 'create';
      } else {
        this.form = this._.clone(data);
        this.mode = 'edit';
      }
    },
    initSelectedPermissions() {
      this.selectedPermissions = [];

      if (this._.isEmpty(this.form.permissions)) {
        return;
      }

      this._.forEach(this.form.permissions, permission => {
        this.selectedPermissions.push(permission.id);
      });
    },
    initPermissions() {
      this.permissionsDataSet = [];

      this._.forEach(this.permissions, permission => {
        this.permissionsDataSet.push({
          key: permission.id,
          label: permission.name,
        });
      });
    },
    async handleSubmit() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        this.form.permission_ids = this.selectedPermissions;
        const uri = (this.mode === 'edit')
            ? this.route('admin.ajax_update_role', {role: this.form.id})
            : this.route('admin.ajax_create_role');
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
