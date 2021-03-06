@extends('layouts.app')

@section('title', 'Login')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="padding-top: 15px;">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Login...</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">


                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="form-group row">
                                                <label for="identifier"
                                                       class="col-md-4 col-form-label text-md-right">{{ ucfirst(siteSetting('authentication.registration_identifier.identifier', 'email')) }}</label>

                                                <div class="col-md-6">
                                                    <input id="identifier" type="text"
                                                           class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}"
                                                           name="identifier" value="{{ old('identifier') }}" required
                                                           autofocus>

                                                    @if ($errors->has('identifier'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('identifier') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password"
                                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password" type="password"
                                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                           name="password" required>

                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6 offset-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Remember Me') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-block btn-primary">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                            @if (Route::has('password.request'))
                                                <div class="form-group row">
                                                    <div class="col-md-6 offset-md-4">
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            {{ __('Forgot Your Password?') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group row">
                                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-4">
                                                    <a class="btn btn-link" href="{{ route('register') }}">
                                                        {{ __('I\'m new here!') }}
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(is_array(siteSetting('thirdPartyAuthentication.providers', [])) && count(siteSetting('thirdPartyAuthentication.providers', [])) > 0)
                        <div class="col-md-3" style="border-left: 2px solid black">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Or login with...</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <social-login
                                        :providers="{{json_encode(siteSetting('thirdPartyAuthentication.providers'))}}"></social-login>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
