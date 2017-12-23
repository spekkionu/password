
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');
import Vuex from 'vuex';
import BootstrapVue from 'bootstrap-vue'
import store from './store.js';

Vue.use(Vuex);
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('sites', require('./components/Sites.vue'));
Vue.component('site', require('./components/Site.vue'));
Vue.component('add-site', require('./components/AddSite.vue'));
Vue.component('edit-site', require('./components/EditSite.vue'));
Vue.component('delete-site', require('./components/DeleteSite.vue'));
Vue.component('add-section', require('./components/section/AddSection.vue'));
Vue.component('site-section', require('./components/section/Section.vue'));
Vue.component('edit-section', require('./components/section/EditSection.vue'));
Vue.component('delete-section', require('./components/section/DeleteSection.vue'));
Vue.component('data-group', require('./components/data/Data.vue'));
Vue.component('add-data', require('./components/data/AddData.vue'));
Vue.component('edit-data', require('./components/data/EditData.vue'));
Vue.component('delete-data', require('./components/data/DeleteData.vue'));

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
});
