<template>
        <v-layout>
            <v-flex xs12>
                <v-tabs id="form-tabs" grow scroll-bars v-model="active" light>
                    <v-tabs-bar slot="activators" class="red">
                        <v-tabs-item href="#form-tabs-basic-data">
                            Basic data
                        </v-tabs-item>
                        <v-tabs-item href="#form-tabs-metadata" ripple>
                            Metadata
                        </v-tabs-item>
                        <v-tabs-slider></v-tabs-slider>
                    </v-tabs-bar>
                    <v-tabs-content id="form-tabs-basic-data">
                        <v-container fluid>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="name"
                                        label="Name"
                                        v-model="form.name"
                                        required
                                        :error="form.errors.has('name')"
                                        :errors="form.errors.get('name')"
                                        hint="Give a name to your category"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-select
                                        :items="categories"
                                        v-model="form.parent_id"
                                        label="Select a category"
                                        dark
                                        single-line
                                        auto
                                        hint="Select the parent category that your category should belong to. Leave this blank to create a primary category"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="body"
                                        label="Body"
                                        v-model="form.body"
                                        required
                                        :error="form.errors.has('body')"
                                        :errors="form.errors.get('body')"
                                        hint="Write some nice promotional text for your category. This can include images, bold text, links, etc."
                                        persistent-hint
                                        multi-line
                                    />
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-tabs-content>
                    <v-tabs-content id="form-tabs-metadata">
                        <v-container fluid>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="title"
                                        label="Page title"
                                        v-model="form.metadata.title"
                                        hint="Here you can write a more catching page title instead of using the category name"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="keywords"
                                        label="Keywords"
                                        v-model="form.metadata.keywords"
                                        hint="Add some keywords to your category. This can improve the online search result ranking of this category"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="description"
                                        label="Description"
                                        v-model="form.metadata.description"
                                        hint="Write some nice promotional text for your category"
                                        persistent-hint
                                        multi-line
                                        max="160"
                                        counter
                                    />
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-tabs-content>
                </v-tabs>
            </v-flex>
            <v-fab class="green" @click.native="save">
                <v-icon light>save</v-icon>
            </v-fab>
        </v-layout>
</template>

<script>
    import Form from '../../classes/Form';
    import Category from '../../classes/Category';
    export default {
        props: ['id'],
        mounted() {
            this.getCategories();
            if(this.id)
            {
                this.form.id = this.id;
                this.getcategoryData();
            }
        },
        data: function ()
        {
            return {
                form: new Form({
                    name: '',
                    parent_id: null,
                    body: '',
                    id: null,
                    metadata: {
                        title: null,
                        keywords: null,
                        description: null
                    }
                }),
                categories: [],
                active: null,
            }
        },
        methods:
        {
            getcategoryData()
            {
                axios.get('/webapi/categories/' + this.form.id).then(function(response){
                    this.form.name = response.data.name;
                    this.form.parent_id = response.data.parent_id;
                    this.form.body = response.data.body;
                    this.form.metadata.title = response.data.metadata.title;
                    this.form.metadata.keywords = response.data.metadata.keywords;
                    this.form.metadata.description = response.data.metadata.description;
                }.bind(this));
            },
            getCategories()
            {
                axios.get('/webapi/categories').then(function(response){
                    response.data.forEach(function(item, index){
                        this.categories.push(new Category(item.id, item.name));
                    }.bind(this));
                }.bind(this));
            },
            save()
            {
                if(this.form.id)
                {
                    this.form.patch('/webapi/categories/' + this.form.id)
                        .then(response => this.$router.push('/categories'))
                        .catch(error => console.log(error));
                }
                else
                {
                    this.form.put('/webapi/categories')
                        .then(response => this.$router.push('/categories'))
                        .catch(error => console.log(error));
                }
            }
        }
    }
</script>
