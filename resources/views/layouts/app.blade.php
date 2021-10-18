@extends('bristolsu::base')

@section('title-prefix'){{config('app.name')}} :: @endsection

@section('title', 'Portal')

@section('content')
    <div id="vue-root">
        @yield('app-content')
    </div>
@endsection
