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
                                        name="title"
                                        label="Title"
                                        v-model="form.title"
                                        required
                                        :error="form.errors.has('title')"
                                        :errors="form.errors.get('title')"
                                        hint="Give a name to your page"
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
                                        hint="Write some nice text for your page. This can include images, bold text, links, etc."
                                        persistent-hint
                                        multi-line
                                    />
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-switch :label="isPublished" v-model="form.published" dark hint="Choose if your page should be published and visible to your visitors" persistent-hint/>
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
    export default {
        props: ['id'],
        mounted() {
            if(this.id)
            {
                this.form.id = this.id;
                this.getpageData();
            }
        },
        data: function ()
        {
            return {
                form: new Form({
                    title: '',
                    body: '',
                    id: null,
                    published: true,
                    metadata: {
                        title: null,
                        keywords: null,
                        description: null
                    }
                }),
                active: null,
            }
        },
        methods:
        {
            getPageData()
            {
                axios.get('/webapi/pages/' + this.form.id).then(function(response){
                    this.form.title = response.data.title;
                    this.form.body = response.data.body;
                    this.form.author_id = response.data.author_id;
                    this.form.published = response.data.published;
                }.bind(this));
            },
            save()
            {
                if(this.form.id)
                {
                    this.form.patch('/webapi/pages/' + this.form.id)
                        .then(response => this.$router.push('/pages'))
                        .catch(error => console.log(error));
                }
                else
                {
                    this.form.put('/webapi/pages')
                        .then(response => this.$router.push('/pages'))
                        .catch(error => console.log(error));
                }
            }
        },
        computed:
        {
            isPublished: function()
            {
                if(this.form.published == true)
                {
                    return 'Published';
                }
                else
                {
                    return 'Unpublished';
                }
            }
        }
    }
</script>
