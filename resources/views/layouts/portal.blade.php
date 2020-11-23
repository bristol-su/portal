@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    @yield('app-content')
@endsection


@push('scripts')
    @include('theme::scripts')
@endpush

@push('styles')
    @include('theme::styles')
@endpush
