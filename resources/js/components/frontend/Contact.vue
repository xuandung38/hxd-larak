<template>
  <el-container class="manager-screen">
    <el-header>
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
              label="ID"
              prop="id"
              sortable
              width="50">
          </el-table-column>

          <el-table-column
              width="100">
            <template slot-scope="scope">
              <el-avatar :alt="scope.row.name" :size="35" :src="scope.row.image" fit="fit" shape="circle">
              </el-avatar>
            </template>
          </el-table-column>

          <el-table-column
              :label="$t('admin.common.name')"
              prop="name"
              sortable>
          </el-table-column>
          <el-table-column label="Phòng ban"
                           prop="department_id" sortable>
            <template slot-scope="scope">
              {{ scope.row.department.name }}
            </template>
          </el-table-column>

          <el-table-column label="Chức vụ">
            <template slot-scope="scope">
              {{ scope.row.position.name }}
            </template>
          </el-table-column>

          <el-table-column
              :label="$t('admin.common.phone')"
              prop="phone"
              sortable>
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
    </el-main>
  </el-container>
</template>
<script>

export default {
  props: {
    users: {
      type: Object,
      default() {
        return {};
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
      let params = {
        per_page: 30
      };
      if (!this._.isEmpty(this.search)) {
        params.search = this.search;
      }
      if (page > 1) {
        params.page = page;
      }
      window.location = this.route('user.contacts_index', params);
    },
  }
}
</script>
