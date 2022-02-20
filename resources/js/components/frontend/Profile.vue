<template>
  <el-container class="manager-screen">
    <el-main>
      <el-row :gutter="20">
        <el-col :span="6" :xs="24">
          <el-card style="margin-bottom:20px;">
            <div slot="header" class="clearfix">
              <span>About me</span>
            </div>

            <div class="user-profile">
              <div class="box-center">
                <el-avatar :size="100" :src="user.image" fit="fit" shape="circle">
                  <div>Hello</div>
                </el-avatar>
              </div>
              <div class="box-center">
                <div class="user-name text-center">{{ user.name }}</div>
              </div>
            </div>
          </el-card>
        </el-col>
        <el-col :span="18" :xs="24">
          <el-card>
            <el-tabs>
              <el-tab-pane :label="$t('admin.common.profile')">
                <el-form
                    :model="userInfo"
                    label-position="left"
                    label-width="120px"
                >
                  <el-form-item :label="$t('admin.common.name')">
                    <el-input
                        v-model="userInfo.name"
                        maxlength="255"
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item :label="$t('admin.common.email')">
                    <el-input
                        v-model="userInfo.email"
                        maxlength="255"
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item :label="$t('admin.common.phone')">
                    <el-input
                        v-model="userInfo.phone"
                        maxlength="255"
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item label="Ngày sinh">
                    <el-date-picker
                        v-model="userInfo.birth_date"
                        type="date"
                        placeholder="Chọn một ngày"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd"
                    >
                    </el-date-picker>
                  </el-form-item>
                  <el-form-item :label="$t('admin.common.image')">
                    <ImageUploader
                        :on-select="handleSelectImage"
                        :source="userInfo.image"
                    />
                  </el-form-item>
                  <el-form-item>
                    <el-button
                        type="success"
                        @click="handleSubmitInfo"
                    >
                      {{ $t('admin.common.save') }}
                    </el-button>
                  </el-form-item>
                </el-form>
              </el-tab-pane>
              <el-tab-pane :label="$t('admin.common.password')">
                <el-form
                    :model="userPassword"
                    class="form-dialog"
                    label-position="left"
                    label-width="200px"
                >
                  <el-form-item :label="$t('admin.common.current_password')">
                    <el-input
                        v-model="userPassword.current"
                        maxlength="255"
                        show-password
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item :label="$t('admin.common.new_password')">
                    <el-input
                        v-model="userPassword.new"
                        maxlength="255"
                        show-password
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item :label="$t('admin.common.retype_password')">
                    <el-input
                        v-model="userPassword.confirm"
                        maxlength="255"
                        show-password
                        show-word-limit
                    ></el-input>
                  </el-form-item>
                  <el-form-item>
                    <el-button
                        type="success"
                        @click="handleSubmitPassword"
                    >
                      {{ $t('admin.common.save') }}
                    </el-button>
                  </el-form-item>
                </el-form>
              </el-tab-pane>
            </el-tabs>
          </el-card>
        </el-col>

      </el-row>
    </el-main>
  </el-container>
</template>
<script>
import ImageUploader from "../common/ImageUploader";

export default {
  components: {ImageUploader},
  props: {
    user: {
      Type: Object,
      default() {
        return {};
      },
    },
    userRoles: {
      type: Array,
      default() {
        return [];
      }
    },
  },
  data() {
    return {
      userInfo: this._.clone(this.user),
      userPassword: {},
    };
  },
  methods: {
    handleSelectImage(image) {
      if (!this._.isEmpty(image)) {
        this.userInfo.image = image;
      }
    },
    async handleSubmitInfo() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('user.update_profile');
        await this.Request.patch(uri, this.userInfo);
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.update_profile_success'),
        });
        const redirect = this.route('user.profile');
        setTimeout(function () {
          window.location = redirect;
        }, 1000)
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
    async handleSubmitPassword() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('user.update_password');
        await this.Request.patch(uri, this.userPassword);
        this.userPassword = {};
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.change_password_success'),
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
<style lang="scss" scoped>
.box-center {
  margin: 0 auto;
  display: table;
}

.text-muted {
  color: #777;
}

.user-profile {
  .user-name {
    font-weight: bold;
  }

  .box-center {
    padding-top: 10px;
  }

  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }

}
</style>
