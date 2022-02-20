<template>
  <div class="login-form">
    <div class="">
      <p class="title">
        {{ $t('dashboard.forget_password') }}
      </p>
      <div class="text-box">
        <el-input
            v-model="form.email"
            placeholder="Email"
            prefix-icon="el-icon-user"
        ></el-input>
      </div>
      <div class="button-box">
        <el-button
            class="login-button box-shadow"
            type="success"
            @click="handleSubmitForget"
        >{{ $t('dashboard.send') }}
        </el-button>
      </div>
      <div class="guide-text">
        <div class="guide-left">
          <a href="#"
             @click="onAction('login')"
          >{{ $t('dashboard.login') }}</a>
        </div>
        <div class="guide-right">
          <a v-if="guard ==='user'"
             href="#"
             @click="onAction('register')"
          >{{ $t('dashboard.register') }}</a>
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
    onAction: {
      Type: Function,
      default() {
        return null
      }
    }
  },
  data() {
    return {
      form: {},
    };
  },
  methods: {
    async handleSubmitForget() {
      const loading = this.$loading({
        lock: true,
        text: this.$t('dashboard.loading'),
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin' ? this.route('auth.create_admin_reset_password_token') : this.route('auth.create_user_reset_password_token');
        await this.Request.post(uri, this.form);
        this.$notify({
          type: 'success',
          title: this.$t('dashboard.success'),
          message: this.$t('message.create_reset_password_success'),
        });
        loading.close();
        this.onAction('login')
      } catch (e) {
        console.log(e); // eslint-disable-line
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
