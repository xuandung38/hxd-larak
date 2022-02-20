<template>
  <div class="login-form box-shadow">
    <div class="left full-width">
      <p class="title">
        {{ $t('dashboard.reset_password') }}
      </p>
      <div class="text-box">
        <el-input
            v-model="form.password"
            :placeholder="$t('dashboard.password')"
            :show-password="true"
            prefix-icon="el-icon-key"
            type="password"
        ></el-input>
      </div>
      <div class="text-box">
        <el-input
            v-model="form.password_confirm"
            :placeholder="$t('dashboard.retype_password')"
            :show-password="true"
            prefix-icon="el-icon-key"
            type="password"
        ></el-input>
      </div>
      <div class="button-box">
        <el-button
            class="login-button box-shadow"
            type="success"
            @click="handleSubmitReset"
        >{{ $t('dashboard.save') }}
        </el-button>
      </div>
      <div class="guide-text">
        <div class="guide-left">
          <a href="#"
             @click="onAction('login')"
          >{{ $t('dashboard.login') }}</a>
        </div>
        <a v-if="guard ==='user'"
           href="#"
           @click="onAction('register')"
        >{{ $t('dashboard.register') }}</a>
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
    token: {
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
      form: {},
    };
  },
  methods: {
    async handleSubmitReset() {
      const loading = this.$loading({
        lock: true,
        text: this.$t('dashboard.loading'),
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.guard === 'admin'
            ? this.route('auth.reset_admin_password', {token: this.token})
            : this.route('auth.reset_user_password', {token: this.token});
        await this.Request.post(uri, this.form);
        this.$notify({
          type: 'success',
          title: this.$t('dashboard.success'),
          message: this.$t('message.password_updated'),
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
