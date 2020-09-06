@extends('layouts.portal')

@section('title', 'Login')

@section('app-content')
    <p-login
        route="{{route('login')}}">
    </p-login>
@endsection
