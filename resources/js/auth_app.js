import Vue from 'vue';
import ElementUI from 'element-ui';
import ElementUILocale from 'element-ui/lib/locale/lang/vi'
import VueLodash from 'vue-lodash';
import lodash from 'lodash';
import i18n from './plugins/i18n';
import Helper from './plugins/helper';
import Request from './plugins/request';
import Router from './plugins/router';

Vue.use(ElementUI, {locale: ElementUILocale});
Vue.use(VueLodash, {lodash: lodash});
Vue.prototype.Helper = Helper;
Vue.prototype.Request = Request;

Vue.mixin({
    methods: {
        route: (name, params, absolute) => Router.route(name, params, absolute),
    }
});

const files = require.context('./components/auth', true, /\.vue$/i); // eslint-disable-line no-undef
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

new Vue({
    el: '#app',
    i18n,
});

