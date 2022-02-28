require('./bootstrap');

window.Vue = require('vue');
import router from "./router";
import {Form, HasError, AlertError} from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import moment from 'moment';
import Swal from 'sweetalert2'
import CKEditor from 'ckeditor4-vue';
import store from "./store";
import i18n from "./lang/i18n";
import SortedTablePlugin from "vue-sorted-table";

Vue.use(SortedTablePlugin);
window.Swal = Swal;
window.Fire = new Vue();
Vue.use(CKEditor);

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;

import ReadMore from 'vue-read-more';

Vue.use(ReadMore);

Vue.component('admin', require('./components/Test').default);
Vue.component('owl',
    require('./components/customer/home/Owl').default);

Vue.filter('myDate', function (created) {
    moment.locale();
    return moment(created).format('L');
});

Vue.filter('chartDate', function (created) {
    moment.locale();
    return moment(created).format('DD-MM');
});

Vue.component('pagination', require('laravel-vue-pagination'));
// import jQuery from "../../public/assets/customer/fashi/js/jquery-3.3.1.min.js"
// import jQuery from 'jquery';
// import "../../public/assets/customer/fashi/js/owl.carousel.min.js"
// import 'jquery';
// window.$ = window.jQuery = require("jquery");
import VueAgile from 'vue-agile'
Vue.use(VueAgile);
window.i18n = i18n;

import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'
Vue.use(Chartkick.use(Chart));

import VueNumberInput from '@chenfengyuan/vue-number-input';
Vue.use(VueNumberInput);

import { VueperSlides, VueperSlide } from 'vueperslides'
import 'vueperslides/dist/vueperslides.css'

const app = new Vue({
    el: '#app',
    router,
    i18n,
    store,
});


