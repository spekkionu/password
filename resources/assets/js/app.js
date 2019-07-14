
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

Vue.component('sites', require('./components/Sites.vue').default);
Vue.component('site', require('./components/Site.vue').default);
Vue.component('add-site', require('./components/AddSite.vue').default);
Vue.component('edit-site', require('./components/EditSite.vue').default);
Vue.component('delete-site', require('./components/DeleteSite.vue').default);
Vue.component('add-section', require('./components/section/AddSection.vue').default);
Vue.component('site-section', require('./components/section/Section.vue').default);
Vue.component('edit-section', require('./components/section/EditSection.vue').default);
Vue.component('delete-section', require('./components/section/DeleteSection.vue').default);
Vue.component('data-group', require('./components/data/Data.vue').default);
Vue.component('add-data', require('./components/data/AddData.vue').default);
Vue.component('edit-data', require('./components/data/EditData.vue').default);
Vue.component('delete-data', require('./components/data/DeleteData.vue').default);

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
});
