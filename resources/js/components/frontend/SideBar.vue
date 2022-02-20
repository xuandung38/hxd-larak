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
          <a :href="this.route('user.profile')"><span>{{ user.name }}</span></a>
        </div>
      </div>
      <ul class="nav">
        <template>
          <li v-for="menu in menues" :key="menu.name" :class="activeRoute === menu.name ? 'active' : ''">
            <a v-if="!menu.hasOwnProperty('child')" :href="menu.route">
              <i class="material-icons">{{ menu.icon }}</i>
              <p> {{ menu.label }}
                <el-badge v-if="menu.new > 0" :value="menu.new" class="item"/>
              </p>
            </a>
            <a v-if="menu.hasOwnProperty('child')" :href="'#'+menu.groupRoute" aria-expanded="true" class="nav-link collapsed"
               data-toggle="collapse">
              <i class="material-icons">{{ menu.icon }}</i>
              <p> {{ menu.label }}
                <el-badge v-if="menu.new > 0" :value="menu.new" class="item"/>
                <b class="caret"></b>
              </p>
            </a>
            <div v-if="menu.hasOwnProperty('child')" :id="menu.groupRoute" aria-expanded="true"
                 class="collapse in">
              <ul class="nav" style="background-color: #1d2b40">
                <li v-for="itemChild in menu.child" :key="itemChild.name"
                    :class="activeRoute === itemChild.name ? 'active' : ''">
                  <a :href="itemChild.route" class="nav-link" style="margin-left: 33px;">
                    <i class="material-icons">{{ itemChild.icon }}</i>
                    <span class="sidebar-normal"> {{ itemChild.label }} <el-badge v-if="itemChild.new > 0" :value="itemChild.new"
                                                                                  class="item"/> </span>
                  </a>
                </li>
              </ul>
            </div>
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
    unreadMessageCount: {
      Type: Number,
      default() {
        return 0;
      }
    },
    activeRoute: {
      Type: String,
      default: '',
    },
    groupRoute: {
      Type: String,
      default: '',
    }
  },
  data() {
    return {
      menues: [
        {
          name: 'user.profile',
          route: this.route('user.profile'),
          label: 'Profile',
          icon: 'description',
          new: 0
        },
      ],
    };
  },
}
</script>
