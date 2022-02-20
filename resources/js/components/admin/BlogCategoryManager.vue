<template>
  <el-container class="manager-screen">
    <el-header>
      <div class="left">
        <el-button
            icon="el-icon-edit-outline"
            type="success"
            @click="showForm()"
        >
          {{ this.$t('admin.common.create') }}
        </el-button>
      </div>
      <div class="right">
        <el-input
            v-model="search"
            :placeholder="this.$t('admin.common.search')"
            class="search"
            @keyup.enter.native="handlePaginate(1)"
        />
      </div>
    </el-header>
    <el-main>
      <el-card class="box-card">
        <el-table
            :data="categoriesDataSet"
            :default-sort="{prop: '_lft', order: 'ascending' }"
            style="width: 100%">
          <el-table-column
              label="Mã danh mục"
              prop="id"
              sortable
          />
          <el-table-column
              :label="$t('admin.common.name')"
              prop="name"
              sortable/>
          <el-table-column
              :label="$t('admin.common.parent')"
              prop="parent_category.name"
              sortable/>
          <el-table-column
              :label="$t('admin.common.action')"
              fixed="right"
          >
            <template slot-scope="scope">
              <el-button
                  :title="$t('admin.common.edit')"
                  class="action-button"
                  icon="el-icon-edit"
                  plain
                  size="mini"
                  type="primary"
                  @click="showForm(scope.row)"
              >
                {{ $t('admin.common.edit') }}
              </el-button>
              <el-button
                  :title="$t('admin.common.delete')"
                  class="action-button"
                  icon="el-icon-delete"
                  plain
                  size="mini"
                  type="danger"
                  @click="confirmDelete(scope.row)"
              >
                {{ $t('admin.common.delete') }}
              </el-button>
            </template>
          </el-table-column>
        </el-table>
        <div class="pagination">
          <el-pagination
              v-if="categories.total > categories.per_page"
              :current-page="categories.current_page"
              :page-size="categories.per_page"
              :total="categories.total"
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
        <blog-category-form
            :on-cancel="hideForm"
            :on-success="onSuccess"
            :target="target"
        />
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
import BlogCategoryForm from "./BlogCategoryForm";
import DeleteConfirmDialog from './DeleteConfirmDialog';

export default {
  components: {BlogCategoryForm, DeleteConfirmDialog},
  props: {
    categories: {
      type: Object,
      default() {
        return {};
      },
    },
    user: {
      type: Object,
      default() {
        return {};
      },
    },
    keyword: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      search: this.keyword,
      categoriesDataSet: this.categories.data,
      formTitle: '',
      isShowForm: false,
      isShowConfirmDelete: false,
      target: {},
    }
  },
  methods: {
    confirmDelete(target) {
      this.target = target
      this.isShowConfirmDelete = true
    },
    closeDeleteDialog() {
      this.isShowConfirmDelete = false;
    },
    onSuccess(data, mode) {
      this.isShowForm = false;
      if (this._.isEmpty(data)) {
        return;
      }
      if (mode === 'create') {
        this.categoriesDataSet.push(data);
      } else {
        this.categoriesDataSet = this._.map(this.categoriesDataSet, (record) => {
          return (record.id === data.id) ? data : record;
        });
      }
      this.hideForm();
    },
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
      window.location = this.route('admin.blog_categories_index', params);
    },
    async handleDelete() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.ajax_delete_blog_category', {id: this.target.id});
        await this.Request.delete(uri);
        this.categoriesDataSet.splice(this._.findIndex(this.categoriesDataSet, this.target), 1);
        this.isShowConfirmDelete = false;
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.common.deleted'),
        });
      } catch (e) {
        const errorMessages = this.Request.errors(e.response);
        this.$notify({
          type: 'error',
          title: this.$t('admin.common.error'),
          message: this._.isEmpty(errorMessages) ? this.$t('admin.common.unknown_error') : errorMessages[0],
        });
      }
      loading.close();
    },
    hideForm() {
      this.isShowForm = false;
    },
    showForm(target) {
      this.formTitle = this._.isEmpty(target)
          ? this.$t('admin.common.create')
          : this.$t('admin.common.edit') + ' #' + target.id;
      this.target = target;
      this.isShowForm = true
    },
  }
}
</script>
