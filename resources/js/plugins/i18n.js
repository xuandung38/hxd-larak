import en from '../lang/en.json';
import vi from '../lang/vi.json';
import VueI18n from 'vue-i18n';
import Vue from 'vue';

Vue.use(VueI18n);

const messages = {
    en,
    vi,
}

const i18n = new VueI18n({
    locale: document.querySelector('meta[name="locale"]').getAttribute('content') || en,
    messages: messages
});

export default i18n;
