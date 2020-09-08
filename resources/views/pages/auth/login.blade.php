@extends('layouts.portal')

@section('title', 'Login')

@section('app-content')
    TEST
    <p-login
        route="{{route('login')}}"
        default-identifier="{{old('identifier')}}"
        :default-remember="{{ (old('remember', false) ? 'true' : 'false') }}"
        :server-errors="{{(count($errors) > 0 ? json_encode($errors) : '{}' )}}"
    >
    </p-login>
@endsection
