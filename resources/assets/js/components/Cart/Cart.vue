<template>
    <div class="container">
        <div class="row">
            <h2>Shopping Cart</h2>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-9">
                <table class="table table-striped table-condensed" id="cart_products">
                    <thead>
                        <tr>
                            <th class="td-img">Product</th>
                            <th></th>
                            <th class="text-center td-qty">Quantity</th>
                            <th class="text-center td-price">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <v-cart-item v-for="item in items" key="id" :item="item" @updated="getCart" @deleted="getCart"/>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-5 offset-md-7 col-8 offset-4">
                        <div class="row" id="order_delivery">
                            <div class="col-6 text-right text-muted" title="Delivery will be updated after choosing a new delivery method">Delivery:</div>
                            <div class="col-6 text-right text-muted">
                                <span style="white-space: nowrap;">{{ cart.shipping_in_currency }}</span>
                            </div>
                        </div>
                        <div class="row" id="order_total_untaxed">
                            <span class="col-6 text-right text-muted">Subtotal:</span>
                            <span class="col-6 text-right text-muted">
                                <span style="white-space: nowrap;">{{ cart.subtotal_in_currency }}</span>
                            </span>
                        </div>
                        <div class="row" id="order_total_taxes">
                            <span class="col-6 text-right text-muted" title="Taxes may be updated after providing shipping address"> Taxes:</span>
                            <span class="col-6 text-right text-muted">
                                <span style="white-space: nowrap;">{{ cart.taxes_in_currency}}</span>
                            </span>
                        </div>
                        <hr>
                        <div class="row" id="order_total">
                            <span class="col-6 text-right h4">Total:</span>
                            <span class="col-6 text-right h4" style="white-space: nowrap;">
                                <span style="white-space: nowrap;">{{ cart.total_in_currency }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CartItem from './CartItem.vue';
    export default {
        components: {
            'v-cart-item': CartItem
        },
        data: function() {
            return {
                cart: {},
                items: []
            };
        },
        created() {
            this.getCart();
        },
        methods: {
            getCart()
            {
                axios.get('/cart')
                .then(function(response){
                    this.cart = response.data;
                    this.items = this.cart.cart_items
                }.bind(this));
            }
        }
    }
</script>
