@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    <div id="vue-root">
        @yield('app-content')
    </div>
@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@prepend('scripts')
    <script src="{{mix('js/app.js')}}"></script>
@endprepend
