{{--TODO Is this the best way?--}}

@push('fonts')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@endpush

@push('styles')
    @include('templates.javascript_injection')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@prepend('scripts')
    <script src="{{mix('js/app.js')}}"></script>
@endprepend('scripts)

@push('meta-tags')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
