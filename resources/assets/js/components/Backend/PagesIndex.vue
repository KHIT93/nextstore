<template>
    <v-layout>
        <v-flex xs12>
            <table class="table datatable elevation-1">
                <thead>
                    <tr>
                        <th class="text-xs-left">Page ID</th>
                        <th class="text-xs-left">Page Title</th>
                        <th class="text-xs-left">Author</th>
                        <th class="text-xs-left">Published</th>
                        <th/>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="page in pages">
                        <td>{{ page.id }}</td>
                        <td>{{ page.title }}</td>
                        <td>{{ page.author.name }}</td>
                        <td>{{ page.published }}</td>
                        <td>
                            <v-btn icon :to="{ name: 'pages.edit', params: { id: page.id }}" router>
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn icon class="error--text" @click.native="openDialog(page)">
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-fab class="indigo" to="/pages/create" router>
            <v-icon light>add</v-icon>
        </v-fab>
        <v-dialog v-model="dialog" persistent>
            <v-card>
                <v-card-row>
                    <v-card-title>Delete page</v-card-title>
                </v-card-row>
                <v-card-row>
                    <v-card-text>Are you sure that you want to delete {{ this.chosen_page.name }}</v-card-text>
                </v-card-row>
                <v-card-row actions>
                    <v-btn class="green--text darken-1" flat="flat" @click.native="cancelDialog">No</v-btn>
                    <v-btn class="red--text darken-1" flat="flat" @click.native="deletePage">Yes</v-btn>
                </v-card-row>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        mounted() {
            this.getPages();
        },
        data: function ()
        {
            return {
                pages: [],
                error: null,
                dialog: false,
                chosen_page: { name: '' }
            }
        },
        methods:
        {
            getPages()
            {
                axios.get('/webapi/pages').then(function(response){
                    this.pages = response.data;
                }.bind(this))
                .catch(function(error)
                {
                    console.log(error);
                    this.error = error;
                });
            },
            openDialog(page)
            {
                this.chosen_page = page;
                this.dialog = true;
            },
            cancelDialog()
            {
                this.dialog = false;
                this.chosen_page = { name: '' };
            },
            deletePage()
            {
                axios.delete('/webapi/pages/' + this.chosen_page.id)
                    .then(function(response){
                        console.log(response);
                        this.chosen_page = { name: '' };
                        this.dialog = false;
                        this.getpages();
                    }.bind(this));
            }
        }
    }
</script>
