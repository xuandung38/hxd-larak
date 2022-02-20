<template>
  <div class="login-form">
    <div class="left-side">
      <p class="title">
        Đăng nhập qua IdolCare
      </p>
      <div class="text-box">
        <el-input
            v-model="form.email"
            placeholder="Email"
            prefix-icon="el-icon-user"
        ></el-input>
      </div>
      <div class="text-box">
        <el-input
            v-model="form.password"
            :placeholder="$t('dashboard.password')"
            :show-password="true"
            prefix-icon="el-icon-key"
            type="password"
            @keyup.native.enter="handleSubmitLogin"
        ></el-input>
      </div>
      <div class="text-box">
        <el-checkbox v-model="form.remember">{{ $t('dashboard.remember_me') }}</el-checkbox>
      </div>
      <div class="button-box">
        <el-button
            class="login-button box-shadow"
            type="success"
            @click="handleSubmitLogin"
        >{{ $t('dashboard.login') }}
        </el-button>
      </div>
      <div class="guide-text">
        <div class="guide-left">
          <a
              href="#"
              @click="onAction('forget')"
          >{{ $t('dashboard.forget_password') }}</a>
        </div>
        <div class="guide-right">
          <a
              href="#"
              @click="onAction('register')"
          >{{ $t('dashboard.register') }}</a>
        </div>
      </div>
    </div>
    <div class="right-side">
      <p class="title">
        hoặc qua...
      </p>
      <div class="social-login">
        <div class="sns-item box-shadow">
          <span class="facebook"><i class="fab fa-facebook"></i></span>
          Facebook
        </div>
        <div class="sns-item box-shadow">
          <span class="google"><i class="fab fa-google"></i></span>
          Google
        </div>
        <div class="sns-item box-shadow">
          <span class="twitter"><i class="fab fa-twitter"></i></span>
          Twitter
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
      default: 'user'
    },
    redirect: {
      Type: String,
      default: ''
    },
    onAction: {
      Type: Function,
      default() {
        return null
      }
    }
  },
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
    };
  },
  methods: {
    async handleSubmitLogin() {
      const loading = this.$loading({
        lock: true,
        text: this.$t('dashboard.loading'),
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin' ? this.route('auth.admin_login') : this.route('auth.user_login');
        await this.Request.post(uri, this.form);
        this.$notify({
          type: 'success',
          title: this.$t('dashboard.success'),
          message: this.$t('message.login_success'),
        });
        window.location.reload()
      } catch (e) {
        const errorMessages = this.Request.errors(e.response);
        this.$notify({
          type: 'error',
          title: this.$t('dashboard.error'),
          message: this._.isEmpty(errorMessages) ? this.$t('message.unknown_error') : errorMessages[0],
        });
      }
      loading.close();
    },
  }
}
</script>
