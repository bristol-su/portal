@extends('layouts.portal')

@section('title', 'Login')

@section('app-content')

        <x-theme-alert variant="danger" :dismissible="true">
            Uho, it looks like something went wrong! Give it another go :)
        </x-theme-alert>
        <x-theme-alert variant="success" :dismissible="true">
            Or maybe it went right!
        </x-theme-alert>
        <x-theme-alert variant="warning" :dismissible="true">
            Let's settle with being careful
        </x-theme-alert>
        <x-theme-alert variant="info" :dismissible="false">
            And keep us <a href="#">informed</a>
        </x-theme-alert>

        <x-theme-button variant="info">
            Test
        </x-theme-button>

        <x-theme-spinner variant="info" size="lg" alt="Loading...">

        </x-theme-spinner>
        <x-theme-spinner variant="info" alt="Loading...">

        </x-theme-spinner>
    {{--            <p-form--}}
    {{--                v-slot="{ invalid }"--}}
    {{--                :action="$tools.routes.named.path('login')"--}}
    {{--                method="POST">--}}
    {{--                <v-card>--}}
    {{--                    <v-card-title class="justify-center">--}}
    {{--                        <span class="primary--text"><translate text="Sign In"></translate></span>--}}
    {{--                    </v-card-title>--}}
    {{--                    <v-card-text>--}}
    {{--                        <csrf-token></csrf-token>--}}

    {{--                        <validation-provider--}}
    {{--                            v-slot="{ errors }"--}}
    {{--                            name="identifier"--}}
    {{--                            rules="required">--}}

    {{--                            <v-text-field--}}
    {{--                                :label="$tools.settings.site.get('Authentication.Attributes.IdentifierLabel')"--}}
    {{--                                id="identifier"--}}
    {{--                                name="identifier"--}}
    {{--                                v-model="credentials.identifier"--}}
    {{--                                prepend-icon="mdi-account"--}}
    {{--                                :error-messages="errors"--}}
    {{--                                type="text"--}}
    {{--                                :autofocus="!$tools.validation.server.has('identifier')"--}}
    {{--                            ></v-text-field>--}}
    {{--                        </validation-provider>--}}

    {{--                        <v-text-field--}}
    {{--                            id="password"--}}
    {{--                            label="Password"--}}
    {{--                            name="password"--}}
    {{--                            v-model="credentials.password"--}}
    {{--                            prepend-icon="mdi-lock"--}}
    {{--                            type="password"--}}
    {{--                        ></v-text-field>--}}

    {{--                        <v-switch--}}
    {{--                            id="remember"--}}
    {{--                            name="remember"--}}
    {{--                            class="ma-0"--}}
    {{--                            :input-value="credentials.remember"--}}
    {{--                            @change="credentials.remember = $event"--}}
    {{--                            :label="'Remember me' | translate"--}}
    {{--                            :value="credentials.remember"--}}
    {{--                        ></v-switch>--}}

    {{--                    </v-card-text>--}}
    {{--                    <v-card-actions>--}}
    {{--                        <v-btn color="primary" block type="submit" aria-label="Login" :disabled="invalid"--}}
    {{--                               :loading="loading">--}}
    {{--                            <v-icon>mdi-arrow-right</v-icon>--}}
    {{--                        </v-btn>--}}
    {{--                    </v-card-actions>--}}
    {{--                    <v-card-text>--}}
    {{--                        <v-btn text block href="/register"><translate>I'm new here</translate></v-btn>--}}
    {{--                        <v-btn text block href="/password/reset"><translate>I've forgotten my password</translate></v-btn>--}}
    {{--                    </v-card-text>--}}
    {{--                </v-card>--}}
    {{--            </p-form>--}}
    {{--        </v-col>--}}
    {{--    </v-row>--}}
@endsection
