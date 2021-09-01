@php $legacy = true @endphp
@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    <div id="legacy-vue-root">
        @yield('app-content')
    </div>
@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{mix('js/legacy.js')}}"></script>
@endpush
