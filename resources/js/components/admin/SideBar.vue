<template>
  <div class="sidebar" data-active-color="green" data-background-color="black">
    <div class="logo">
      <a :href="this.route('index')" class="simple-text logo-normal">
        <img alt="Logo" class="logo" src="/images/logo-default.png">
      </a>
    </div>
    <div class="sidebar-wrapper">
      <div class="user">
        <div class="photo">
          <img :alt="user.name" :src="user.image"/>
        </div>
        <div class="info text-middle">
          <a :href="this.route('admin.profile')"><span>{{ user.name }}</span></a>
        </div>
      </div>
      <ul class="nav">
        <li v-for="menu in menues" :key="menu.name" :class="activeRoute === menu.name ? 'active' : ''">
          <a :href="menu.route">
            <i class="material-icons">{{ menu.icon }}</i>
            <p> {{ menu.label }} </p>
          </a>
        </li>
        <template v-if="hasRole(systemRoleId)">
          <li v-for="menu in systemMenues" :key="menu.name" :class="activeRoute === menu.name ? 'active' : ''">
            <a :href="menu.route">
              <i class="material-icons">{{ menu.icon }}</i>
              <p> {{ menu.label }} </p>
            </a>
          </li>
        </template>

      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      Type: Object,
      default() {
        return {};
      },
    },
    systemRoleId: {
      Type: String,
      default: '',
    },
    activeRoute: {
      Type: String,
      default: '',
    }
  },
  data() {
    return {
      menues: [
        {
          name: 'admin.users_index',
          route: this.route('admin.users_index'),
          label: 'Nhân Viên',
          icon: 'people',
        },
        {
          name: 'admin.blog_categories_index',
          route: this.route('admin.blog_categories_index'),
          label: 'DM tin tức',
          icon: 'library_books',
        },
        {
          name: 'admin.posts_index',
          route: this.route('admin.posts_index'),
          label: 'Tin tức',
          icon: 'description',
        },
        {
          name: 'admin.setting_index',
          route: this.route('admin.setting_index'),
          label: 'Cài đặt',
          icon: 'settings',
        },
      ],
      systemMenues: [
        {
          name: 'admin.admins_index',
          route: this.route('admin.admins_index'),
          label: 'Quản trị viên',
          icon: 'supervised_user_circle',
        },
        {
          name: 'admin.roles_index',
          route: this.route('admin.roles_index'),
          label: 'Phân quyền',
          icon: 'accessibility',
        },
      ],
    };
  },
  methods: {
    hasRole(roleId) {
      const role = this._.find(this.user.roles, role => role.id.toString() === roleId.toString());
      return !this._.isEmpty(role);
    },

  },
}
</script>
