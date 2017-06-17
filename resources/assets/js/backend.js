
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import Vuetify from 'vuetify';
import VueRouter from 'vue-router'
import Home from './components/Backend/Home.vue';
import Orders from './components/Backend/Orders.vue';
import NotFound from './components/Backend/NotFound.vue';


Vue.use(Vuetify);
Vue.use(VueRouter);

const routes = [
    { path: '/', component: Home },
    { path: '/orders', component: Orders },

    /*Catchall route to display 404 page*/
    { path: '*', component: NotFound }
];

const router = new VueRouter({
    routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:
    {
        menu: [
            { icon: 'home', title: 'Home', link: '/'},
            { icon: 'shopping_cart', title: 'Orders', link: '/orders'},
            { icon: 'people', title: 'Customers', link: '/customers'},
            { icon: 'book', title: 'Products', link: '/products'},
            { icon: 'loyalty', title: 'Categories', link: '/categories'},
            { icon: 'description', title: 'Pages', link: '/pages'},
            { icon: 'settings', title: 'Configuration', link: '/configuration'},
        ]
    },
    methods:
    {
        logout()
        {
            axios.post('/logout', {}).then(function(){
                window.location.href = '/';
            });
        }
    }
});
