<template>
        <v-row
            justify="center"
            align="center">
            <v-col
                cols="12"
                sm="8"
                md="4">
                <v-card>
                    <v-card-title class="justify-center">
                        <span class="primary--text">Sign In</span>
                    </v-card-title>
                    <v-card-text>
                        <v-form>
                            <v-text-field
                                label="Login"
                                name="login"
                                prepend-icon="mdi-account"
                                type="text"
                            ></v-text-field>

                            <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" block>Login <v-icon>mdi-arrow-right</v-icon></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
<!--                                        <form method="POST" action="{{ route('login') }}">-->
<!--                                            @csrf-->

<!--                                            <div class="form-group row">-->
<!--                                                <label for="identifier"-->
<!--                                                       class="col-md-4 col-form-label text-md-right">{{ ucfirst(siteSetting('authentication.registration_identifier.identifier')) }}</label>-->

<!--                                                <div class="col-md-6">-->
<!--                                                    <input id="identifier" type="text"-->
<!--                                                           class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}"-->
<!--                                                           name="identifier" value="{{ old('identifier') }}" required-->
<!--                                                           autofocus>-->

<!--                                                    @if ($errors->has('identifier'))-->
<!--                                                    <span class="invalid-feedback" role="alert">-->
<!--                                        <strong>{{ $errors->first('identifier') }}</strong>-->
<!--                                    </span>-->
<!--                                                    @endif-->
<!--                                                </div>-->
<!--                                            </div>-->

<!--                                            <div class="form-group row">-->
<!--                                                <label for="password"-->
<!--                                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->

<!--                                                <div class="col-md-6">-->
<!--                                                    <input id="password" type="password"-->
<!--                                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"-->
<!--                                                           name="password" required>-->

<!--                                                    @if ($errors->has('password'))-->
<!--                                                    <span class="invalid-feedback" role="alert">-->
<!--                                        <strong>{{ $errors->first('password') }}</strong>-->
<!--                                    </span>-->
<!--                                                    @endif-->
<!--                                                </div>-->
<!--                                            </div>-->

<!--                                            <div class="form-group row">-->
<!--                                                <div class="col-md-6 offset-md-4">-->
<!--                                                    <div class="form-check">-->
<!--                                                        <input class="form-check-input" type="checkbox" name="remember"-->
<!--                                                               id="remember" {{ old('remember') ? 'checked' : '' }}>-->

<!--                                                        <label class="form-check-label" for="remember">-->
<!--                                                            {{ __('Remember Me') }}-->
<!--                                                        </label>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->

<!--                                            <div class="form-group row mb-0">-->
<!--                                                <div class="col-md-8 offset-md-4">-->
<!--                                                    <button type="submit" class="btn btn-primary">-->
<!--                                                        {{ __('Login') }}-->
<!--                                                    </button>-->

<!--                                                    @if (Route::has('password.request'))-->
<!--                                                    <a class="btn btn-link" href="{{ route('password.request') }}">-->
<!--                                                        {{ __('Forgot Your Password?') }}-->
<!--                                                    </a>-->
<!--                                                    @endif-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </form>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            @if(is_array(siteSetting('thirdPartyAuthentication.providers', [])) && count(siteSetting('thirdPartyAuthentication.providers', [])) > 0)-->
<!--                            <div class="col-md-3" style="border-left: 2px solid black">-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <h5>Or login with...</h5>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <social-login :providers="{{json_encode(siteSetting('thirdPartyAuthentication.providers'))}}"></social-login>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            @endif-->
<!--                        </div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
export default {
    name: "PLogin"
}
</script>

<style scoped>

</style>
