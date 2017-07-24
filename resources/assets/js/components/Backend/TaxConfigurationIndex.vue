<template>
    <v-layout>
        <v-flex xs12>
            <table class="table datatable elevation-1">
                <thead>
                    <tr>
                        <th class="text-xs-left">Tax ID</th>
                        <th class="text-xs-left">Name</th>
                        <th class="text-xs-left">Amount</th>
                        <th/>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="tax in taxes">
                        <td>{{ tax.id }}</td>
                        <td>{{ tax.name }}</td>
                        <td>{{ tax.value }}</td>
                        <td>
                            <v-btn icon :to="{ name: 'taxes.edit', params: { id: tax.id }}" router>
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn icon class="error--text" @click.native="openDialog(tax)">
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-fab class="indigo" to="/configuration/taxes/create" router>
            <v-icon light>add</v-icon>
        </v-fab>
        <v-dialog v-model="dialog" persistent>
            <v-card>
                <v-card-row>
                    <v-card-title>Delete tax</v-card-title>
                </v-card-row>
                <v-card-row>
                    <v-card-text>Are you sure that you want to delete {{ this.chosen_tax.name }}</v-card-text>
                </v-card-row>
                <v-card-row actions>
                    <v-btn class="green--text darken-1" flat="flat" @click.native="cancelDialog">No</v-btn>
                    <v-btn class="red--text darken-1" flat="flat" @click.native="deleteTax">Yes</v-btn>
                </v-card-row>
            </v-card>
        </v-dialog>
    </v-layout>
</template>
<script>
export default {
    mounted() {
        this.getTaxes();
    },
    data: function ()
    {
        return {
            taxes: [],
            error: null,
            dialog: false,
            chosen_tax: { name: '' }
        }
    },
    methods:
    {
        getTaxes()
        {
            axios.get('/webapi/taxes').then(function(response){
                this.taxes = response.data;
            }.bind(this))
            .catch(function(error)
            {
                console.log(error);
                this.error = error;
            });
        },
        openDialog(tax)
        {
            this.chosen_tax = tax;
            this.dialog = true;
        },
        cancelDialog()
        {
            this.dialog = false;
            this.chosen_tax = { name: '' };
        },
        deleteTax()
        {
            axios.delete('/webapi/taxes/' + this.chosen_tax.id)
                .then(function(response){
                    console.log(response);
                    this.chosen_tax = { name: '' };
                    this.dialog = false;
                    this.getTaxes();
                }.bind(this));
        }
    }
}
</script>
