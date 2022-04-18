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
        <el-button
            class="action-button"
            icon="el-icon-download"
            type="primary"
            @click="handleExport"
        >
          {{ $t('admin.common.export') }}
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
            :data="usersDataSet"
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
              :label="$t('admin.common.username')"
              prop="username"
              sortable>
          </el-table-column>
          <el-table-column
              :label="$t('admin.common.email')"
              prop="email"
              sortable>
          </el-table-column>
          <el-table-column
              :label="$t('admin.common.phone')"
              prop="phone"
              sortable>
          </el-table-column>
          <el-table-column
              :label="$t('admin.common.action')"
              fixed="right">
            <template slot-scope="scope">
              <el-button
                  :title="$t('admin.common.transaction_histories')"
                  class="action-button"
                  icon="el-icon-s-marketing"
                  size="mini"
                  @click="showHistories(scope.row)"
              />
              <el-button
                  :title="$t('admin.common.edit')"
                  class="action-button"
                  icon="el-icon-edit"
                  plain
                  size="mini"
                  type="primary"
                  @click="showForm(scope.row)"
              />
              <el-button
                  :title="$t('admin.common.delete')"
                  class="action-button"
                  icon="el-icon-delete"
                  plain
                  size="mini"
                  type="danger"
                  @click="confirmDelete(scope.row)"
              />
            </template>
          </el-table-column>
        </el-table>
        <div class="pagination">
          <el-pagination
              v-if="users.total > users.per_page"
              :current-page="users.current_page"
              :page-size="users.per_page"
              :total="users.total"
              background
              layout="prev, pager, next"
              @current-change="handlePaginate"
          />
        </div>
      </el-card>
      <el-dialog
          :title="formTitle"
          :visible.sync="isShowForm"
          class="form-dialog"
      >
        <user-form
            :on-cancel="hideForm"
            :on-success="onSuccess"
            :target="target"
        ></user-form>
      </el-dialog>
      <delete-confirm-dialog
          :message="confirmDeleteMessage"
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
import UserForm from './UserForm';

export default {
  components: {UserForm, DeleteConfirmDialog},
  props: {
    users: {
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
      search: '',
      usersDataSet: this._.clone(this.users.data),
      isShowConfirmDelete: false,
      confirmDeleteMessage: '',
      isShowForm: false,
      target: {},
      formTitle: '',
      formHistoryTitle: '',
      isShowHistoryForm: false,
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
      window.location = this.route('admin.users_index', params);
    },
    showForm(target) {
      this.target = target;
      this.formTitle = this._.isEmpty(target)
          ? this.$t('admin.common.create')
          : this.$t('admin.common.edit') + '#' + target.id;
      this.isShowForm = true;
    },
    showHistories(target) {
      this.target = target;
      this.formHistoryTitle = 'Lịch sử giao dịch ' + target.name;
      this.isShowHistoryForm = true;
    },
    onSuccess(user, mode) {
      this.hideForm();
      if (this._.isEmpty(user)) {
        return;
      }
      if (mode === 'create') {
        this.usersDataSet.push(user);
      } else {
        this.usersDataSet = this._.map(this.usersDataSet, (record) => {
          return (record.id === user.id) ? user : record;
        });
      }
    },
    hideForm() {
      this.isShowForm = false;
    },
    confirmDelete(target) {
      this.isShowConfirmDelete = true;
      this.confirmDeleteMessage = 'Bạn chắc chắn muốn xóa ' + target.name + ' ?';
      this.target = target;
    },
    closeDeleteDialog() {
      this.isShowConfirmDelete = false;
    },
    handleExport() {
      window.open(this.route('admin.users_export'), '_blank');
    },
    async handleDelete() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.ajax_delete_user', {user: this.target.id});
        await this.Request.delete(uri);
        this.usersDataSet.splice(this._.findIndex(this.usersDataSet, this.target), 1);
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
