<template>
  <div>
    <div class="form-login">
      <img alt="Logo" class="img-responsive" height="auto" src="/images/logo.png" width="200">
      <div class="card card-login">
        <h4 class="card-title text-center">{{ formTitle }}</h4>
        <div class="card-body">
          <div class="row">
            <div v-if="action === 'login'" class="col-sm-12 mr-auto">
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                  <input v-model="form.email" class="form-control" placeholder="Email..." type="email">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                  <input v-model="form.password"
                         class="form-control"
                         placeholder="Mật khẩu..."
                         type="password"
                         @keyup.enter="handleSubmitLogin"
                  >
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-danger btn-round" type="submit" @click="handleSubmitLogin">Đăng nhập</button>
              </div>
            </div>
            <div v-if="action === 'register'" class="col-sm-12 mr-auto">
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">assignment_ind</i>
                                    </span>
                  <input v-model="formRegister.name" class="form-control" placeholder="Họ tên..." type="text">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                  <input v-model="formRegister.email" class="form-control" placeholder="Email..." type="email">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">phone</i>
                                    </span>
                  <input v-model="formRegister.phone" class="form-control" placeholder="Điện thoại..." type="text">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                  <input v-model="formRegister.password" class="form-control" placeholder="Mật khẩu..." type="password">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                  <input v-model="formRegister.password_confirm" class="form-control" placeholder="Nhập lại mật khẩu..." type="password">
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-success btn-round" type="submit" @click="handleSubmitRegister">Đăng ký</button>
              </div>
            </div>
            <div v-if="action === 'forget'" class="col-sm-12 mr-auto">
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                  <input v-model="formForget.email" class="form-control" placeholder="Email..." type="email">
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-success btn-round" type="submit" @click="handleSubmitForget">Đặt lại mật khẩu</button>
              </div>
            </div>
            <div v-if="action === 'reset'" class="col-sm-12 mr-auto">
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                  <input v-model="formReset.password" class="form-control" placeholder="Mật khẩu..." type="password">
                </div>
              </div>
              <div class="form-group bmd-form-group">
                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                  <input v-model="formReset.password_confirm" class="form-control" placeholder="Nhập lại mật khẩu..." type="password">
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-success btn-round" type="submit" @click="handleSubmitReset">Đặt lại mật khẩu</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center">
      <div class="row">
        <div v-if="action !== 'register' && guard ==='user'" class="col-sm-6">
          <a class="text-white" href="#" @click="handleRegister">Đăng ký</a>
        </div>
        <div v-if="action !== 'login'" class="col-sm-6">
          <a class="text-white" href="#" @click="handleLogin">Đăng nhập</a>
        </div>
        <div v-if="action !== 'forget'" class="col-sm-6">
          <a class="text-white" href="#" @click="handleForgetPassword">Quên mật khẩu</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    guard: {
      Type: String,
      default: ''
    },
    screen: {
      Type: String,
      default: ''
    },
    token: {
      Type: String,
      default: ''
    },
    redirect: {
      Type: String,
      default: ''
    },
  },
  data() {
    return {
      formTitle: '',
      form: {
        email: '',
        password: ''
      },
      formReset: {
        password: '',
        password_confirm: ''
      },
      formForget: {
        email: '',
      },
      formRegister: {
        name: '',
        email: '',
        phone: '',
        password: '',
        password_confirm: ''
      },
      action: this.screen,
      user: {},
    };
  },
  created() {
    this.genFormTitle();
  },
  methods: {
    genFormTitle() {
      switch (this.action) {
        case 'login':
          this.formTitle = 'Đăng nhập';
          break;
        case 'register':
          this.formTitle = 'Đăng ký';
          break;
        case 'forget':
          this.formTitle = 'Quên mật khẩu';
          break;
        case 'reset':
          this.formTitle = 'Đặt lại mật khẩu';
          break;
      }
    },
    handleLogin() {
      this.action = 'login';
      this.genFormTitle();
    },
    handleRegister() {
      this.action = 'register';
      this.genFormTitle();
    },
    handleForgetPassword() {
      this.action = 'forget';
      this.genFormTitle();
    },
    async handleSubmitReset() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin'
            ? this.route('auth.reset_admin_password', {token: this.token})
            : this.route('auth.reset_user_password', {token: this.token});
        const response = await this.Request.post(uri, this.formReset);
        this.user = response.data.user;
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.password_updated'),
        });
        const redirectUri = this.route('index');
        setTimeout(function () {
          window.location = redirectUri;
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
    async handleSubmitForget() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin' ? this.route('auth.create_admin_reset_password_token') : this.route('auth.create_user_reset_password_token');
        await this.Request.post(uri, this.formForget);
        this.handleLogin();
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.create_reset_password_success'),
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
    async handleSubmitLogin() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin' ? this.route('auth.admin_login') : this.route('auth.user_login');
        const response = await this.Request.post(uri, this.form);
        this.user = response.data.user;
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.login_success'),
        });

        let redirectUri = this.guard === 'admin' ? this.route('admin.index') : this.route('index');
        if (!this._.isEmpty(this.redirect)) {
          redirectUri = this.redirect;
        }
        setTimeout(function () {
          window.location = redirectUri;
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
    async handleSubmitRegister() {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('auth.register_user');
        const response = await this.Request.post(uri, this.formRegister);
        this.user = response.data.user;
        this.$notify({
          type: 'success',
          title: this.$t('admin.common.success'),
          message: this.$t('admin.message.register_success'),
        });
        const redirectUri = this.route('index');
        setTimeout(function () {
          window.location = redirectUri;
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
  }
}
</script>
