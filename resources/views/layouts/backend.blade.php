<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NeXTStore') }}</title>
    <!-- Font library and icon pack -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <v-app>
            <v-navigation-drawer permanent clipped light>
                <v-list dense class="pt-0">
                    <template v-for="(item, i) in menu">
                    <v-list-group v-if="item.children" v-model="item.model" no-action>
                        <v-list-item slot="item">
                            <v-list-tile>
                                <v-list-tile-action>
                                    <v-icon>@{{ item.icon }}</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>
                                        @{{ item.title }}
                                    </v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-icon>@{{ item.model ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list-item>
                        <v-list-item v-for="(child, i) in item.children" :key="i">
                            <v-list-tile :to=child.link router exact ripple>
                                <v-list-tile-action v-if="child.icon">
                                    <v-icon>@{{ child.icon }}</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>
                                        @{{ child.title }}
                                    </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list-item>
                    </v-list-group>
                    <v-list-item v-else>
                        <v-list-tile :to=item.link router exact ripple>
                            <v-list-tile-action>
                                <v-icon>@{{ item.icon }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    @{{ item.title }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list-item>
                </template>
            </v-navigation-drawer>
            <v-toolbar class="red" light>
                <v-toolbar-title>{{ config('app.name', 'NeXTStore') }}</v-toolbar-title>
                <v-toolbar-items>
                    <v-menu left bottom origin="bottom right" transition="v-slide-y-transition">
                        <v-btn light icon slot="activator">
                            <v-icon>account_circle</v-icon>
                        </v-btn>
                        <v-list>
                            <v-list-item>
                                <v-list-tile>
                                    <v-list-tile-title>Change Account</v-list-tile-title>
                                </v-list-tile>
                                <v-list-tile @click.native="logout">
                                    <v-list-tile-title>Log Out</v-list-tile-title>
                                </v-list-tile>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar-items>
            </v-toolbar>
            <main>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </main>
        </v-app>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/backend.js') }}"></script>
</body>
</html>
