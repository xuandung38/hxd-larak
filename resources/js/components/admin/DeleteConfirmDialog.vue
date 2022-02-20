<template>
  <div>
    <el-dialog
        :title="title"
        :visible.sync="isShow"
        center
        class="delete-dialog"
        @close="onCancel"
    >
      <p v-if="message !== ''" class="text-center">{{ message }}</p>
      <p v-else class="text-center">{{ this.$t('admin.message.confirm_delete_message') }}</p>
      <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="onConfirm">{{ this.$t('admin.common.confirm') }}</el-button>
            <el-button @click="onCancel">{{ this.$t('admin.common.cancel') }}</el-button>
        </span>
    </el-dialog>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      Type: String,
      default: '',
    },
    message: {
      Type: String,
      default: '',
    },
    visible: {
      Type: Boolean,
      default: false,
    },
    onCancel: {
      Type: Function,
      default() {
        return null;
      },
    },
    onConfirm: {
      Type: Function,
      default() {
        return null;
      },
    },
  },
  data() {
    return {
      isShow: this._.clone(this.visible),
    };
  },
  watch: {
    isShow(data) {
      if (!data) {
        this.onCancel();
      }
    },
    visible(data) {
      this.isShow = data;
    }
  },
}
</script>
