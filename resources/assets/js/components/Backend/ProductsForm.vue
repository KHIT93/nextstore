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
                                        hint="Give a name to your product"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-select
                                        :items="categories"
                                        v-model="form.category_id"
                                        label="Select a category"
                                        dark
                                        single-line
                                        auto
                                        hint="Select the category that your product should belong to"
                                        persistent-hint
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="teaser"
                                        label="Teaser"
                                        v-model="form.teaser"
                                        required
                                        :error="form.errors.has('teaser')"
                                        :errors="form.errors.get('teaser')"
                                        hint="Give a short description or teaser for your product"
                                        persistent-hint
                                        max="160"
                                        counter
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="description"
                                        label="Description"
                                        v-model="form.description"
                                        required
                                        :error="form.errors.has('description')"
                                        :errors="form.errors.get('description')"
                                        hint="Write a full description of your product"
                                        persistent-hint
                                        max="500"
                                        counter
                                        multi-line
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
                                        hint="Write some nice promotional text for your product. This can include images, bold text, links, etc."
                                        persistent-hint
                                        multi-line
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field
                                        name="price"
                                        label="Price"
                                        v-model="form.price"
                                        :error="form.errors.has('price')"
                                        :errors="form.errors.get('price')"
                                        hint="Give your product a price without taxes and VAT"
                                        persistent-hint
                                        type="number"
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-layout>
                                        <v-flex sm3 v-for="(image, index) in images" :key="image.id">
                                            <v-product-image :imgid="image.id" @deleted="getImages" @selected="selectImage"/>
                                        </v-flex>
                                    </v-layout>
                                    <v-dropzone v-if="form.id" id="vDropZoneProductImages" :url="image_postback_url" v-on:vdropzone-success="showSuccess" :show-remove-link="show_remove_link">
                                        <input type="hidden" name="_token" :value="csrfToken"/>
                                    </v-dropzone>
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
    import DropZone from 'vue2-dropzone';
    import ProductImage from './ProductImage.vue';
    export default {
        props: ['id'],
        mounted() {
            this.getCategories();
            if(this.id)
            {
                this.form.id = this.id;
                this.getProductData();
                this.image_postback_url = '/webapi/products/' + this.id + '/images';
            }
        },
        data: function ()
        {
            return {
                form: new Form({
                    name: '',
                    category_id: null,
                    teaser: '',
                    description: '',
                    body: '',
                    price: 0,
                    image_id: '',
                    id: null,
                    metadata: {
                        title: null,
                        keywords: null,
                        description: null
                    }
                }),
                categories: [],
                active: null,
                show_remove_link: false,
                csrfToken: window.Laravel.csrfToken,
                image_postback_url: '',
                images: []
            }
        },
        components: {
            'v-dropzone': DropZone,
            'v-product-image': ProductImage,
        },
        methods:
        {
            getProductData()
            {
                axios.get('/webapi/products/' + this.form.id).then(function(response){
                    this.form.name = response.data.name;
                    this.form.category_id = response.data.category_id;
                    this.form.teaser = response.data.teaser;
                    this.form.description = response.data.description;
                    this.form.body = response.data.body;
                    this.form.price = response.data.price;
                    this.form.metadata.title = response.data.metadata.title;
                    this.form.metadata.keywords = response.data.metadata.keywords;
                    this.form.metadata.description = response.data.metadata.description;
                    this.images = response.data.images;
                }.bind(this));
            },
            getCategories()
            {
                axios.get('/webapi/categories?nochildren&noparent').then(function(response){
                    response.data.forEach(function(item, index){
                        this.categories.push(new Category(item.id, item.name));
                    }.bind(this));
                }.bind(this));
            },
            save()
            {
                if(this.form.id)
                {
                    this.form.patch('/webapi/products/' + this.form.id)
                        .then(response => this.$router.push('/products'))
                        .catch(error => console.log(error));
                }
                else
                {
                    this.form.put('/webapi/products')
                        .then(response => this.$router.push('/products'))
                        .catch(error => console.log(error));
                }
            },
            showSuccess: function (file) {
                console.log('A file was successfully uploaded');
                this.getImages();

            },
            getImages() {
                axios.get(this.image_postback_url).then(function(response){
                    this.images = response.data;
                }.bind(this));
            },
            selectImage(event, payload) {
                console.log(event);
                this.form.image_path = event;
            }
        }
    }
</script>
