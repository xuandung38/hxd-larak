<template>
  <div class="login-form">
    <div>
      <p class="title">
        {{ $t('dashboard.register') }}
      </p>
      <div class="text-box">
        <el-input
            v-model="form.name"
            :placeholder="$t('dashboard.name')"
            prefix-icon="el-icon-user"
        ></el-input>
      </div>
      <div class="text-box">
        <el-input
            v-model="form.email"
            placeholder="Email"
            prefix-icon="el-icon-user"
        ></el-input>
      </div>
      <div class="text-box">
        <el-input
            v-model="form.phone"
            :placeholder="$t('dashboard.phone')"
            prefix-icon="el-icon-phone"
        ></el-input>
      </div>
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
        <el-button class="login-button box-shadow"
                   type="success"
                   @click="handleSubmitRegister"
        >{{ $t('dashboard.register') }}
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
              @click="onAction('login')"
          >{{ $t('dashboard.login') }}</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
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
    async handleSubmitRegister() {
      let loading = this.$loading({
        lock: true,
        text: this.$t('dashboard.loading'),
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('auth.register_user');
        await this.Request.post(uri, this.form);

        this.$notify({
          type: 'success',
          title: this.$t('dashboard.success'),
          message: this.$t('message.register_success'),
        });
        loading.close();
        this.onAction('login')

      } catch (e) {
        const errorMessages = this.Request.errors(e.response);
        this.$notify({
          type: 'error',
          title: this.$t('dashboard.error'),
          message: this._.isEmpty(errorMessages) ? this.$t('message.unknown_error') : errorMessages[0],
        });
        loading.close();
      }
    },
  }
}
</script>
