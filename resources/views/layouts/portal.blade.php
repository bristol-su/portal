@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    @yield('app-content')
@endsection

@push('scripts')
{{--        <script src="{{ webpack('portal.js') }}"></script>--}}
@endpush
