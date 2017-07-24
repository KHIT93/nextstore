
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}*/

import ProductCard from './components/Products/ProductCard.vue';
import Product from './components/Products/Product.vue';
import Cart from './components/Cart/Cart.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        'v-product-card': ProductCard,
        'v-product': Product,
        'v-cart': Cart
    }
});
