<template>
  <div>
    <Login
        v-if="currentAction === 'login'"
        :guard="guard"
        :on-action="onAction"
    ></Login>
    <Register
        v-if="currentAction === 'register'"
        :guard="guard"
        :on-action="onAction"
    ></Register>
    <ForgetPassword
        v-if="currentAction === 'forget'"
        :guard="guard"
        :on-action="onAction"
    ></ForgetPassword>
  </div>
</template>
<script>
import Login from "./Login";
import Register from "./Register";
import ForgetPassword from "./ForgetPassword";

export default {
  components: {Login, Register, ForgetPassword},
  props: {
    guard: {
      Type: String,
      default: 'user'
    },
    action: {
      Type: String,
      default: ''
    }
  },
  data() {
    return {
      currentAction: this._.clone(this.action),
    }
  },
  watch: {
    action(payload) {
      this.currentAction = payload
    }
  },
  methods: {
    onAction(action) {
      this.currentAction = action
    }
  }
}
</script>
