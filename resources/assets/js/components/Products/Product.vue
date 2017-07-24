<template>
    <article>
        <section class="container mt2">
            <div class="row">
                <div class="col-sm-7">
                    <img data-src="holder.js/100px280/thumb" :alt="product.name">
                </div>
                <div class="col-sm-5">
                    <h1 class="h1">{{ product.name }}</h1>
                    <form action="/cart" method="POST" @submit.prevent="save">
                        <h4 class="mt2 h4">${{ product.price }}</h4>
                        <input type="hidden" name="product_id" v-model="form.product_id"/>
                        <div class="input-group" style="max-width: 150px;">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-secondary" @click="subQty">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </span>
                            <input type="number" class="form-control text-center" min="1" name="qty" v-model="form.qty" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-secondary" @click="addQty">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg mt1">Add to cart</button>
                    </form>
                    <hr>
                    <p class="text-muted">{{ product.description }}</p>
                    <hr>
                </div>
            </div>
        </section>
        <hr>
        <section class="container-fluid">
            {{ product.body }}
        </section>
    </article>
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
            addQty()
            {
                this.form.qty++;
            },
            subQty()
            {
                if(this.form.qty > 1)
                {
                    this.form.qty--;
                }
            }
        }
    }
</script>
