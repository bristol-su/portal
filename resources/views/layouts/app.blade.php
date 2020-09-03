@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    <div id="portal-vue-root">
        @yield('app-content')
    </div>
@endsection

@push('styles')
    <link href="{{ webpack('app.css') }}" rel="stylesheet">
@endpush

@prepend('scripts')
    <script src="{{webpack('app.js')}}"></script>
@endprepend
