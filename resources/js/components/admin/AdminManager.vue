<template>
  <el-container class="manager-screen">
    <el-header>
      <div class="left">
        <el-button
            class="action-button"
            icon="el-icon-edit-outline"
            type="success"
            @click="showForm({})"
        >
          {{ $t('admin.common.create') }}
        </el-button>
      </div>
      <div class="right">
        <el-input
            v-model="search"
            :placeholder="$t('admin.common.search')"
            class="search"
            @keyup.enter.native="handlePaginate(1)"
        />
      </div>
    </el-header>
    <el-main>
      <el-card class="box-card">
        <el-table
            :data="adminsDataSet"
            style="width: 100%">
          <el-table-column
              label="Mã tài khoản"
              prop="id"
              sortable
          />
          <el-table-column
              :label="$t('admin.common.name')"
              prop="name"
              sortable>
          </el-table-column>
          <el-table-column
              label="Email"
              prop="email"
              sortable>
          </el-table-column>
          <el-table-column
              :label="$t('admin.common.phone')"
              prop="phone"
              sortable>
          </el-table-column>
          <el-table-column :label="$t('admin.common.role')">
            <template slot-scope="scope">
              <p
                  v-for="role in scope.row.roles"
                  :key="role.id"
                  class="text-left"
              >
                {{ role.name }}
              </p>
            </template>
          </el-table-column>
          <el-table-column
              :label="$t('admin.common.action')"
              fixed="right">
            <template slot-scope="scope">
              <el-button
                  v-if="canEdit(scope.row)"
                  :title="$t('admin.common.edit')"
                  class="action-button"
                  icon="el-icon-edit"
                  plain
                  size="mini"
                  type="primary"
                  @click="showForm(scope.row)"
              >
              </el-button>
              <el-button
                  v-if="canDelete(scope.row)"
                  :title="$t('admin.common.delete')"
                  class="action-button"
                  icon="el-icon-delete"
                  plain
                  size="mini"
                  type="danger"
                  @click="confirmDelete(scope.row)"
              >
              </el-button>
            </template>
          </el-table-column>
        </el-table>
        <div class="pagination">
          <el-pagination
              v-if="admins.total > admins.per_page"
              :current-page="admins.current_page"
              :page-size="admins.per_page"
              :total="admins.total"
              background
              layout="prev, pager, next"
              @current-change="handlePaginate"
          />
        </div>
      </el-card>
      <el-dialog
          :title="formTitle"
          :visible.sync="isShowForm"
          width="50%"
      >
        <admin-form
            :admin-roles="adminRoles"
            :on-cancel="hideForm"
            :on-success="onSuccess"
            :target="target"
        ></admin-form>
      </el-dialog>
      <delete-confirm-dialog
          :on-cancel="closeDeleteDialog"
          :on-confirm="handleDelete"
          :title="this.$t('admin.common.confirm_delete')"
          :visible="isShowConfirmDelete"
      />
    </el-main>
  </el-container>
</template>
<script>
import DeleteConfirmDialog from "./DeleteConfirmDialog";
import AdminForm from './AdminForm';

export default {
  components: {AdminForm, DeleteConfirmDialog},
  props: {
    admins: {
      type: Object,
      default() {
        return {};
      }
    },
    adminRoles: {
      type: Array,
      default() {
        return [];
      }
    },
    user: {
      type: Object,
      default() {
        return {};
      }
    },
  },
  data() {
    return {
      search: '',
      adminsDataSet: this._.clone(this.admins.data),
      isShowConfirmDelete: false,
      isShowForm: false,
      target: {},
      formTitle: '',
      adminLevel: this.getRoleLevel(this.user.roles),
    }
  },
  methods: {
    handlePaginate(page) {
      this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      let params = {};
      if (!this._.isEmpty(this.search)) {
        params.search = this.search;
      }
      if (page > 1) {
        params.page = page;
      }
      window.location = this.route('admin.admins_index', params);
    },
    getRoleLevel(roles) {
      let level = null;

      this._.forEach(roles, role => {
        if (level === null || level > role.level) {
          level = role.level;
        }
      });

      return level;
    },
    canEdit(record) {
      if (this.user.id === record.id) {
        return true;
      }
      const level = this.getRoleLevel(record.roles);

      return level > this.adminLevel;
    },
    canDelete(record) {
      const level = this.getRoleLevel(record.roles);

      return level > this.adminLevel;
    },
    showForm(target) {
      this.target = target;
      this.formTitle = this._.isEmpty(target)
          ? this.$t('admin.common.create')
          : this.$t('admin.common.edit') + '#' + target.id;
      this.isShowForm = true;
    },
    onSuccess(user, mode) {
      this.hideForm();
      if (this._.isEmpty(user)) {
        return;
      }
      if (mode === 'create') {
        this.adminsDataSet.push(user);
      } else {
        this.adminsDataSet = this._.map(this.adminsDataSet, (record) => {
          return (record.id === user.id) ? user : record;
        });
      }
    },
    hideForm() {
      this.isShowForm = false;
    },
    confirmDelete(target) {
      this.isShowConfirmDelete = true;
      this.target = target;
    },
    closeDeleteDialog() {
      this.isShowConfirmDelete = false;
    },
    async handleDelete() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.ajax_delete_admin', {admin: this.target.id});
        await this.Request.delete(uri);
        this.adminsDataSet.splice(this._.findIndex(this.adminsDataSet, this.target), 1);
        this.isShowConfirmDelete = false;
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.common.deleted'),
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
  }
}
</script>
