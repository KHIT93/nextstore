<template>
    <div class="card product col-sm-4">
        <img data-src="holder.js/100px280/thumb" :alt="product.name">
        <p class="card-text"><strong>{{ product.name }}</strong></p>
        <p class="card-text">{{ product.teaser }}</p>
        <p class="card-text">${{ product.price }}</p>
        <div class="row">
            <div class="col-sm-6">
                <form action="/cart" method="POST" @submit.prevent="save">
                    <input type="hidden" name="product_id" v-model="form.product_id"/>
                    <input type="hidden" name="qty" v-model="form.qty"/>
                    <button type="submit" class="btn btn-success btn-block">Add to cart</button>
                </form>
            </div>
            <div class="col-sm-6">
                <button type="button" class="btn btn-secondary btn-block" @click="readmore">Read more</button>
            </div>
        </div>
    </div>
</template>
<script>
    import Form from '../../classes/Form';
    export default {
        props: ['product'],
        data: function() {
            return {
                form: new Form({
                    product_id: this.product.id,
                    qty: 1
                }),
            };
        },
        methods: {
            save() {
                this.form.post('/cart');
            },
            readmore() {
                window.location.href = '/products/' + this.product.id;
            },
        }
    }
</script>
