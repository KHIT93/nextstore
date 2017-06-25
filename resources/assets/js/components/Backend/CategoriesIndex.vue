<template>
    <v-layout>
        <v-flex xs12>
            <table class="table datatable elevation-1">
                <thead>
                    <tr>
                        <th class="text-xs-left">Category ID</th>
                        <th class="text-xs-left">Category Name</th>
                        <th class="text-xs-left">Parent</th>
                        <th/>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td v-if="category.parent_id != null">{{ category.parent.name }}</td>
                        <td v-if="category.parent_id == null"></td>
                        <td>
                            <v-btn icon :to="{ name: 'categories.edit', params: { id: category.id }}" router>
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn icon class="error--text" @click.native="openDialog(category)">
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-fab class="indigo" to="/categories/create" router>
            <v-icon light>add</v-icon>
        </v-fab>
        <v-dialog v-model="dialog" persistent>
            <v-card>
                <v-card-row>
                    <v-card-title>Delete category</v-card-title>
                </v-card-row>
                <v-card-row>
                    <v-card-text>Are you sure that you want to delete {{ this.chosen_category.name }}</v-card-text>
                </v-card-row>
                <v-card-row actions>
                    <v-btn class="green--text darken-1" flat="flat" @click.native="cancelDialog">No</v-btn>
                    <v-btn class="red--text darken-1" flat="flat" @click.native="deletecategory">Yes</v-btn>
                </v-card-row>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        mounted() {
            this.getcategories();
        },
        data: function ()
        {
            return {
                categories: [],
                error: null,
                dialog: false,
                chosen_category: { name: '' }
            }
        },
        methods:
        {
            getcategories()
            {
                axios.get('/webapi/categories?nochildren').then(function(response){
                    this.categories = response.data;
                }.bind(this))
                .catch(function(error)
                {
                    console.log(error);
                    this.error = error;
                });
            },
            openDialog(category)
            {
                this.chosen_category = category;
                this.dialog = true;
            },
            cancelDialog()
            {
                this.dialog = false;
                this.chosen_category = { name: '' };
            },
            deletecategory()
            {
                axios.delete('/webapi/categories/' + this.chosen_category.id)
                    .then(function(response){
                        console.log(response);
                        this.chosen_category = { name: '' };
                        this.dialog = false;
                        this.getcategories();
                    }.bind(this));
            }
        }
    }
</script>
