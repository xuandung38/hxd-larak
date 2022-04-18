import Vue from 'vue';
import Vuex from 'vuex';
import ElementUI from 'element-ui';
import ElementUILocale from 'element-ui/lib/locale/lang/vi'
import i18n from './plugins/i18n';
import Helper from './plugins/helper';
import Request from './plugins/request';
import Router from './plugins/router';
import {adminStore} from './stores/adminStore';
import VueLodash from 'vue-lodash';
import lodash from 'lodash';

Vue.use(ElementUI, {locale: ElementUILocale});
Vue.use(Vuex);
Vue.use(VueLodash, {lodash: lodash});

Vue.prototype.Request = Request;
Vue.prototype.Helper = Helper;

Vue.mixin({
    methods: {
        route: (name, params, absolute) => Router.route(name, params, absolute),
    }
});

const adminComponents = require.context('./components/admin', true, /\.vue$/i); // eslint-disable-line no-undef
// const chartComponents = require.context('./components/charts', true, /\.vue$/i); // eslint-disable-line no-undef
adminComponents.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], adminComponents(key).default));
// chartComponents.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], chartComponents(key).default));

new Vue({
    store: adminStore,
    el: '#app',
    i18n,
});

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.getElementById('preloader').style.visibility = 'hidden';
    }, 100);
});

