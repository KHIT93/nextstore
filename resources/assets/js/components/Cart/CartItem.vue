<template>
    <tr>
        <td align="center" class="td-img">
            <span><img class="img img-responsive" data-src="holder.js/100px65/thumb"></span>
        </td>
        <td class="td-product_name">
            <div>
                <a :href="'/products/'+item.product_id">
                    <strong>{{ item.product.name }}</strong>
                </a>
            </div>
            <div class="text-muted hidden-xs small">
                {{ item.product.teaser }}
            </div>
            <a href="#" class="hidden-xs no-decoration" @click.prevent="updateItem"> <small><i class="fa fa-refresh"></i> Update</small></a>
            <a href="#" class="hidden-xs no-decoration" @click.prevent="deleteItem"> <small><i class="fa fa-trash-o"></i> Remove</small></a>
        </td>
        <td class="text-center td-qty">
            <div class="input-group">
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
        </td>
        <td class="text-center td-price" name="price">
            <span style="white-space: nowrap;">{{ item.total_in_currency }}</span>
        </td>
    </tr>
</template>
<script>
    import Form from '../../classes/Form';
    export default {
        props: ['item'],
        data: function() {
            return {
                form: new Form({product_id: this.item.product_id, qty: this.item.qty})
            };
        },
        methods: {
            addQty()
            {
                this.form.qty++;
                this.form.patch('/cart').then(function(response){
                    this.$emit('updated');
                }.bind(this));

            },
            subQty()
            {
                if(this.item.qty > 1)
                {
                    this.form.qty--;
                    this.form.patch('/cart').then(function(response){
                        this.$emit('updated');
                    }.bind(this));
                }
            },
            updateItem()
            {
                this.form.patch('/cart').then(function(response){
                    this.$emit('updated');
                }.bind(this));
            },
            deleteItem()
            {
                this.form.delete('/cart').then(function(response){
                    this.$emit('deleted');
                }.bind(this));
            }
        }
    }
</script>
