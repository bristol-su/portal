@extends('layouts.portal')

@section('title', 'Login')

@section('app-content')
    <p-login
        route="{{route('login')}}"
        default-identifier="{{old('identifier')}}"
        :default-remember="{{ (old('remember', false) ? 'true' : 'false') }}"
        :server-errors="{{(count($errors) > 0 ? $errors : '{}' )}}"
    >
    </p-login>
@endsection
