<template>
        <v-layout>
            <v-flex xs12>
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
                                hint="Give a name to your tax"
                                persistent-hint
                            />
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12>
                            <v-text-field
                                name="value"
                                label="Amount"
                                v-model="form.value"
                                required
                                :error="form.errors.has('value')"
                                :errors="form.errors.get('value')"
                                hint="Give your tax a percentage value"
                                persistent-hint
                                type="number"
                                min="0"
                            />
                        </v-flex>
                    </v-layout>
                </v-container>
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
            this.getTaxes();
            if(this.id)
            {
                this.form.id = this.id;
                this.getTaxData();
            }
        },
        data: function ()
        {
            return {
                form: new Form({
                    name: '',
                    value: null,
                }),
                taxes: [],
            }
        },
        methods:
        {
            getTaxData()
            {
                axios.get('/webapi/taxes/' + this.form.id).then(function(response){
                    this.form.name = response.data.name;
                    this.form.value = response.data.value;
                }.bind(this));
            },
            getTaxes()
            {
                axios.get('/webapi/taxes').then(function(response){
                    this.taxes = response.data;
                }.bind(this));
            },
            save()
            {
                if(this.form.id)
                {
                    this.form.patch('/webapi/taxes/' + this.form.id)
                        .then(response => this.$router.push('/configuration/taxes'))
                        .catch(error => console.log(error));
                }
                else
                {
                    this.form.put('/webapi/taxes')
                        .then(response => this.$router.push('/configuration/taxes'))
                        .catch(error => console.log(error));
                }
            }
        }
    }
</script>
