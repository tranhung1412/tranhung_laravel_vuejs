window.Vue = require('vue');
import VueI18n from 'vue-i18n'
import vnMessage from './vn.json'
import enMessage from './en.json'
Vue.use(VueI18n);


const messages = {
    vn: vnMessage,
    en: enMessage,
};

export default new VueI18n({
    locale: 'vn', // set locale
    messages,
    fallbackLocale: 'vn',
});

