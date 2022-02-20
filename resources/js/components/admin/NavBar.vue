<template>
  <div>
    <nav class="navbar navbar-transparent navbar-absolute">
      <div class="container-fluid">
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
            <i class="material-icons visible-on-sidebar-mini">view_list</i>
          </button>
        </div>
        <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" type="button">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="navbar-brand">
            <a v-for="link in breadcrumb" :key="link.label" :href="link.route">{{ link.label }}</a>
          </div>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Notifications">
                <i class="material-icons">notifications</i>
                <span v-if="!this._.isEmpty(notifications)" class="notification"> {{ notifications.length }}</span>
                <p class="hidden-lg hidden-md">
                  {{ $t('admin.common.notification') }}
                  <b v-if="!this._.isEmpty(notifications)" class="caret"></b>
                </p>
              </a>
              <ul v-if="!this._.isEmpty(notifications)" class="dropdown-menu">
                <li
                    v-for="notify in notifications"
                    :key="notify.route">
                  <a :href="notify.route" class="notification-message">{{ notify.message }}</a>

                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a :title="$t('admin.common.account')" class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="material-icons">person</i>
                <p class="hidden-lg hidden-md">
                  {{ $t('admin.common.account') }}
                  <b class="caret"></b>
                </p>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a :href="this.route('admin.profile')" :title="$t('admin.common.profile')" class="notification-message">
                    {{ $t('admin.common.profile') }}
                  </a>
                </li>
                <li>
                  <a :href="this.route('auth.admin_logout')" :title="$t('admin.common.logout')"
                     class="notification-message">{{ $t('admin.common.logout') }}</a>
                </li>
              </ul>
            </li>
            <li class="separator hidden-lg hidden-md"></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>

export default {
  props: {
    breadcrumb: {
      Type: Array,
      default() {
        return [];
      },
    },
    notifications: {
      Type: Array,
      default() {
        return [];
      },
    },
  },
}
</script>
