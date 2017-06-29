<template>
    <v-dialog v-model="active" persistent width="600">
        <v-card>
            <v-card-row>
                <v-card-title>Login</v-card-title>
            </v-card-row>
            <v-card-row>
                <v-card-text>
                    <form role="form" method="POST" action="/login" @submit.prevent="login">
                        <v-layout row>
                            <v-flex xs12>
                              <v-text-field
                                name="email"
                                label="Email"
                                v-model="form.email"
                                required
                                :error="form.errors.has('email')"
                                :errors="form.errors.get('email')"
                                type="email"
                                autofocus
                              />
                          </v-flex>
                        </v-layout>
                        <v-layout row>
                            <v-flex xs12>
                              <v-text-field
                                name="password"
                                label="Password"
                                v-model="form.password"
                                required
                                :error="form.errors.has('password')"
                                :errors="form.errors.get('password')"
                                type="password"
                              />
                          </v-flex>
                        </v-layout>
                        <v-btn
                            info :loading="loading" :disabled="loading" type="submit" @click.native="loading = true" class="deep-orange white--text">
                            Log in
                            <span slot="loader" class="custom-loader">
                              <v-icon>cached</v-icon>
                            </span>
                        </v-btn>
                        <a class="blue--text darken-1 btn btn--flat btn--raised" href="/password/reset">
                            <span class="btn__content">Forgot Password?</span>
                        </a>
                    </form>
                </v-card-text>
            </v-card-row>
            <v-card-row>
                <v-card-text>Please note that this application depends on JavaScript, so it is required that this is enabled in your web browser</v-card-text>
            </v-card-row>
        </v-card>
    </v-dialog>
</template>
<script>
    import Form from '../../classes/Form';
    export default {
        data: function ()
        {
            return {
                form: new Form({
                    email: '',
                    password: null,
                }),
                active: true,
                loading: false,
            }
        },
        methods: {
            login() {
                this.form.post('/login')
                    .then(response => window.location.href = response.path)
                    .catch(error => console.log(error));
            },
        }
    }
</script>
