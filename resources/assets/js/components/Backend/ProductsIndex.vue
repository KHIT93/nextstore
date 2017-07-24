<template>
    <v-layout>
        <v-flex xs12>
            <table class="table datatable elevation-1">
                <thead>
                    <tr>
                        <th class="text-xs-left">Product ID</th>
                        <th class="text-xs-left">Product Name</th>
                        <th class="text-xs-left">Category</th>
                        <th class="text-xs-left">Price</th>
                        <th/>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products">
                        <td>{{ product.id }}</td>
                        <td>{{ product.name }}</td>
                        <td v-if="product.category_id != null">{{ product.category.name }}</td>
                        <td v-if="product.category_id == null"></td>
                        <td>{{ product.price_formatted }}</td>
                        <td>
                            <v-btn icon :to="{ name: 'products.edit', params: { id: product.id }}" router>
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn icon class="error--text" @click.native="openDialog(product)">
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-fab class="indigo" to="/products/create" router>
            <v-icon light>add</v-icon>
        </v-fab>
        <v-dialog v-model="dialog" persistent>
            <v-card>
                <v-card-row>
                    <v-card-title>Delete product</v-card-title>
                </v-card-row>
                <v-card-row>
                    <v-card-text>Are you sure that you want to delete {{ this.chosen_product.name }}</v-card-text>
                </v-card-row>
                <v-card-row actions>
                    <v-btn class="green--text darken-1" flat="flat" @click.native="cancelDialog">No</v-btn>
                    <v-btn class="red--text darken-1" flat="flat" @click.native="deleteProduct">Yes</v-btn>
                </v-card-row>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        mounted() {
            this.getProducts();
        },
        data: function ()
        {
            return {
                products: [],
                error: null,
                dialog: false,
                chosen_product: { name: '' }
            }
        },
        methods:
        {
            getProducts()
            {
                axios.get('/webapi/products').then(function(response){
                    this.products = response.data;
                }.bind(this))
                .catch(function(error)
                {
                    console.log(error);
                    this.error = error;
                });
            },
            openDialog(product)
            {
                this.chosen_product = product;
                this.dialog = true;
            },
            cancelDialog()
            {
                this.dialog = false;
                this.chosen_product = { name: '' };
            },
            deleteProduct()
            {
                axios.delete('/webapi/products/' + this.chosen_product.id)
                    .then(function(response){
                        console.log(response);
                        this.chosen_product = { name: '' };
                        this.dialog = false;
                        this.getProducts();
                    }.bind(this));
            }
        }
    }
</script>
