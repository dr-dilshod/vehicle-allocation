/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('vehicle-table',require('./components/VehicleTable.vue').default);
Vue.component('shipper-table',require('./components/ShipperTable.vue').default);
Vue.component('driver-table',require('./components/DriverTable.vue').default);
Vue.component('unit-price-table',require('./components/UnitPriceTable').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('item-registration',require('./components/ItemRegistration.vue').default);
Vue.component('invoice',require('./components/Invoice.vue').default);

const app = new Vue({
    el: '#app',
});
