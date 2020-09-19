@extends('bristolsu::base')

@section('title', 'Portal')

@section('content')
    <div id="portal-vue-root">
        @yield('app-content')
    </div>
@endsection

@push('scripts')
{{--        <script src="{{ webpack('portal.js') }}"></script>--}}
@endpush
