/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const $ = require('jquery') //usamos jquery
window.$ = $ //lo colocamos de forma global
import Vuetable from 'vuetable-2/src/components/Vuetable'


window.Vue = require('vue');
Vue.component('Vuetable', Vuetable);

/*-- Componente Menu --*/
Vue.component('comp-menu', require('./components/MenuVue.vue').default);

/*-- Componente Equipos --*/
Vue.component('comp-elemento', require('./components/Elementos/Elemento.vue').default);

/*-- Componente Inspecciones --*/
Vue.component('comp-Inspecciones', require('./components/Inspecciones/Inspecciones.vue').default);

/*-- Componente Sucursales --*/
Vue.component('comp-sucursales', require('./components/Sucursales/Sucursales.vue').default);

/*-- Componente Sucursales --*/
Vue.component('detalle-sectores', require('./components/Sectores/Sectores_Detalle.vue').default);

/*-- Componente Planillas --*/
Vue.component('comp-planilla', require('./components/Planillas/Planilla.vue').default);

/*-- Componente Puestos --*/
Vue.component('Detalle-Puesto', require('./components/Puestos/Puesto_Detalle.vue').default);

/*-- Componente Controles --*/
Vue.component('comp-controlesperiodicos', require('./components/ControlesPeriodicos/ControlesPeriodicos.vue').default);
Vue.component('detalle-controlesperiodicos', require('./components/ControlesPeriodicos/ControlesPeriodicos_Detalle.vue').default);

/*-- Componente buscar --*/
Vue.component('Buscar-component', require('./components/find-generic.vue').default);

/*-- Ver Imagenes --*/
Vue.component('Comp-Imagenes', require('./components/VerImagenes.vue').default);

Vue.component('Comp-pagination', require('./components/DataTable/PaginationBoostrap.vue').default);
Vue.component('comp-footer',require('./components/Footer/Footer.vue').default); 

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
