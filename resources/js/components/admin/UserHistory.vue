<template>
  <el-tabs
      v-model="currentTab"
      class="manager-screen"
      type="border-card"
      @tab-click="handleClickTab"
  >
    <el-tab-pane
        label="Thuê player"
        name="renter-histories"
    >
      <el-table
          :data="renterHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Player"
            prop="player.name"
        />
        <el-table-column
            label="Thời lượng thuê"
            prop="duration"
        >
          <template slot-scope="scope">
            {{ scope.row.duration }}h
          </template>
        </el-table-column>
        <el-table-column
            label="Chi phí"
            prop="cost"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.cost) }}đ
          </template>
        </el-table-column>
        <el-table-column
            :label="$t('admin.common.status')"
            prop="status"
        >
          <template slot-scope="scope">
            {{ scope.row.status_name }}
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="renterHistories.total > renterHistories.per_page"
            :current-page="renterHistories.current_page"
            :page-size="renterHistories.per_page"
            :total="renterHistories.total"
            background
            layout="prev, pager, next"
            @current-change="handlePaginateRenterHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Được thuê"
        name="player-histories"
    >
      <el-table
          :data="playerHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Người thuê"
            prop="renter.name"
        />
        <el-table-column
            label="Thời lượng thuê"
            prop="duration"
        >
          <template slot-scope="scope">
            {{ scope.row.duration }}h
          </template>
        </el-table-column>
        <el-table-column
            label="Chi phí"
            prop="cost"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.cost) }}đ
          </template>
        </el-table-column>
        <el-table-column
            :label="$t('admin.common.status')"
            prop="status"
        >
          <template slot-scope="scope">
            {{ scope.row.status_name }}
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="playerHistories.total > playerHistories.per_page"
            :current-page="playerHistories.current_page"
            :page-size="playerHistories.per_page"
            :total="playerHistories.total"
            background
            layout="prev, pager, next"
            @current-change="handlePaginatePlayerHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Donate"
        name="donator-histories"
    >
      <el-table
          :data="donatorHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Player"
            prop="receiver.name"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }}đ
          </template>
        </el-table-column>
        <el-table-column
            label="Tên hiển thị"
            prop="display_name"
        />
        <el-table-column
            label="Tin nhắn"
            prop="message"
        />
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="donatorHistories.total > donatorHistories.per_page"
            :current-page="donatorHistories.current_page"
            :page-size="donatorHistories.per_page"
            :total="donatorHistories.total"
            background
            layout="prev, pager, next"
            @current-change="handlePaginateDonatorHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Được donate"
        name="receiver-histories"
    >
      <el-table
          :data="receiverHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Nguời donate"
            prop="donator.name"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }}đ
          </template>
        </el-table-column>
        <el-table-column
            label="Tên hiển thị"
            prop="display_name"
        />
        <el-table-column
            label="Tin nhắn"
            prop="message"
        />
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="receiverHistories.total > receiverHistories.per_page"
            :current-page="receiverHistories.current_page"
            :page-size="receiverHistories.per_page"
            :total="receiverHistories.total"
            background
            layout="prev, pager, next"
            @current-change="handlePaginateReceiverHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Nạp tiền"
        name="recharge-histories"
    >
      <el-table
          :data="rechargeHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Mã giao dịch"
            prop="trans_code"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }} đ
          </template>
        </el-table-column>
        <el-table-column
            :label="$t('admin.common.status')"
            prop="status"
        >
          <template slot-scope="scope">
            {{ scope.row.status_name }}
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="rechargeHistories.total > rechargeHistories.per_page"
            :current-page="rechargeHistories.current_page"
            :page-size="rechargeHistories.per_page"
            :total="rechargeHistories.total"
            background
            layout="prev, pager, next"
            @current-change="getRechargeHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Rút tiền"
        name="withdrawal-histories"
    >
      <el-table
          :data="withdrawalHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Mã giao dịch"
            prop="trans_code"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }} đ
          </template>
        </el-table-column>
        <el-table-column
            label="Tài khoản nhận"
            prop="bank_account_number"
        >
          <template slot-scope="scope">
            <p>Số tài khoản: {{ scope.row.bank_account_number }}</p>
            <p>Chủ tài khoản: {{ scope.row.bank_account_name }}</p>
            <p>Ngân hàng: {{ scope.row.bank_name }}</p>
          </template>
        </el-table-column>
        <el-table-column
            :label="$t('admin.common.status')"
            prop="status"
        >
          <template slot-scope="scope">
            {{ scope.row.status_name }}
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="withdrawalHistories.total > withdrawalHistories.per_page"
            :current-page="withdrawalHistories.current_page"
            :page-size="withdrawalHistories.per_page"
            :total="withdrawalHistories.total"
            background
            layout="prev, pager, next"
            @current-change="getWithdrawalHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Mua thẻ"
        name="buy-card-histories"
    >
      <el-table
          :data="buyCardHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Seri"
            prop="serial"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }} đ
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="buyCardHistories.total > buyCardHistories.per_page"
            :current-page="buyCardHistories.current_page"
            :page-size="buyCardHistories.per_page"
            :total="buyCardHistories.total"
            background
            layout="prev, pager, next"
            @current-change="getBuyCardHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Nạp thẻ"
        name="use-card-histories"
    >
      <el-table
          :data="useCardHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Seri"
            prop="serial"
        />
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }} đ
          </template>
        </el-table-column>
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="useCardHistories.total > useCardHistories.per_page"
            :current-page="useCardHistories.current_page"
            :page-size="useCardHistories.per_page"
            :total="useCardHistories.total"
            background
            layout="prev, pager, next"
            @current-change="getUseCardHistories"
        />
      </div>
    </el-tab-pane>
    <el-tab-pane
        label="Biến động số dư"
        name="balance-histories"
    >
      <el-table
          :data="balanceHistories.data"
          :default-sort="{prop: 'id', order: 'descending' }"
          style="width: 100%">
        <el-table-column
            label="Thời gian"
            prop="created_at"
        />
        <el-table-column
            label="Loại"
            prop="is_increase"
        >
          <template slot-scope="scope">
            <span v-if="scope.row.is_increase" class="uk-text-success">Tăng</span>
            <span v-else class="uk-text-danger">Giảm</span>
          </template>
        </el-table-column>
        <el-table-column
            label="Số tiền"
            prop="amount"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.amount) }} đ
          </template>
        </el-table-column>
        <el-table-column
            label="Số dư trước giao dịch"
            prop="before_cash"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.before_cash) }} đ
          </template>
        </el-table-column>
        <el-table-column
            label="Số dư sau giao dịch"
            prop="after_cash"
        >
          <template slot-scope="scope">
            {{ Helper.formatMoney(scope.row.after_cash) }} đ
          </template>
        </el-table-column>
        <el-table-column
            label="Ghi chú"
            prop="note"
        />
      </el-table>
      <div class="pagination p-md-5">
        <el-pagination
            v-if="balanceHistories.total > balanceHistories.per_page"
            :current-page="balanceHistories.current_page"
            :page-size="balanceHistories.per_page"
            :total="balanceHistories.total"
            background
            layout="prev, pager, next"
            @current-change="getBalanceHistories"
        />
      </div>
    </el-tab-pane>
  </el-tabs>
</template>
<script>
export default {
  props: {
    rentStatus: {
      Type: Array,
      default() {
        return [];
      },
    },
    rechargeStatus: {
      Type: Array,
      default() {
        return [];
      },
    },
    withdrawalStatus: {
      Type: Array,
      default() {
        return [];
      },
    },
    user: {
      Type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      renterHistories: [],
      playerHistories: [],
      donatorHistories: [],
      receiverHistories: [],
      rechargeHistories: [],
      withdrawalHistories: [],
      buyCardHistories: [],
      useCardHistories: [],
      balanceHistories: [],
      currentTab: 'renter-histories',
    };
  },
  watch: {
    user() {
      this.resetData();
      this.getRentHistories(1, 'renter');
    }
  },
  mounted() {
    this.getRentHistories(1, 'renter');
  },
  methods: {
    resetData() {
      this.renterHistories = [];
      this.playerHistories = [];
      this.donatorHistories = [];
      this.receiverHistories = [];
      this.rechargeHistories = [];
      this.withdrawalHistories = [];
      this.buyCardHistories = [];
      this.useCardHistories = [];
      this.balanceHistories = [];
      this.currentTab = 'renter-histories';
    },
    prepareRentData(data) {
      return this._.map(data, transaction => {
        transaction.status_name = this._.find(this.rentStatus, status => status.value === transaction.status).name;
        return transaction;
      })
    },
    prepareRechargeData(data) {
      return this._.map(data, transaction => {
        transaction.status_name = this._.find(this.rechargeStatus, status => status.value === transaction.status).name;
        return transaction;
      })
    },
    prepareWithdrawalData(data) {
      return this._.map(data, transaction => {
        transaction.status_name = this._.find(this.withdrawalStatus, status => status.value === transaction.status).name;
        return transaction;
      })
    },
    handleClickTab(tab) {
      switch (tab.name) {
        case 'renter-histories':
          this.getRentHistories(1, 'renter');
          break;
        case 'player-histories':
          this.getRentHistories(1, 'player');
          break;
        case 'donator-histories':
          this.getDonateHistories(1, 'donator');
          break;
        case 'receiver-histories':
          this.getDonateHistories(1, 'receiver');
          break;
        case 'recharge-histories':
          this.getRechargeHistories(1);
          break;
        case 'withdrawal-histories':
          this.getWithdrawalHistories(1);
          break;
        case 'buy-card-histories':
          this.getBuyCardHistories(1);
          break;
        case 'use-card-histories':
          this.getUseCardHistories(1);
          break;
        case 'balance-histories':
          this.getUBalanceHistories(1);
          break;
      }
    },
    handlePaginateRenterHistories(page) {
      this.getRentHistories(page, 'renter');
    },
    handlePaginatePlayerHistories(page) {
      this.getRentHistories(page, 'player');
    },
    handlePaginateDonatorHistories(page) {
      this.getDonateHistories(page, 'donator');
    },
    handlePaginateReceiverHistories(page) {
      this.getDonateHistories(page, 'receiver');
    },
    async getRentHistories(page, type) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_rent_histories', {
          user: this.user.id,
          page: page,
          type: type,
        });
        const response = await this.Request.get(uri);
        if (type === 'renter') {
          this.renterHistories = response.data.rentHistories;
          this.renterHistories.data = this.prepareRentData(this.renterHistories.data);
        } else {
          this.playerHistories = response.data.rentHistories;
          this.playerHistories.data = this.prepareRentData(this.playerHistories.data);
        }
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
    async getDonateHistories(page, type) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_donate_histories', {
          page: page,
          type: type,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        if (type === 'receiver') {
          this.receiverHistories = response.data.donateHistories;

        } else {
          this.donatorHistories = response.data.donateHistories;
        }
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
    async getRechargeHistories(page) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_recharge_histories', {
          page: page,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        this.rechargeHistories = response.data.rechargeHistories;
        this.rechargeHistories.data = this.prepareRechargeData(this.rechargeHistories.data);
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
    async getWithdrawalHistories(page) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_withdrawal_histories', {
          page: page,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        this.withdrawalHistories = response.data.withdrawalHistories;
        this.withdrawalHistories.data = this.prepareWithdrawalData(this.withdrawalHistories.data);
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
    async getBuyCardHistories(page) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_buy_card_histories', {
          page: page,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        this.buyCardHistories = response.data.cardHistories;
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
    async getUseCardHistories(page) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_use_card_histories', {
          page: page,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        this.useCardHistories = response.data.cardHistories;
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
    async getUBalanceHistories(page) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      try {
        const uri = this.route('admin.user_balance_histories', {
          page: page,
          user: this.user.id
        });
        const response = await this.Request.get(uri);
        this.balanceHistories = response.data.balanceHistories;
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
