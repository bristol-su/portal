@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    <p-main>
        <div id="vue-root-portal" v-pre>
            @yield('app-content')
        </div>
    </p-main>
@endsection
