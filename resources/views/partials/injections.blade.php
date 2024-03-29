{{--TODO Is this the best way?--}}

@push('fonts')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@endpush

@push('styles')
    @include('templates.javascript_injection')
    <link rel="stylesheet" href="{{mix('css/ui-kit.css')}}" type="text/css">
    @if(!isset($legacy) || $legacy === false)
        <link rel="stylesheet" href="{{mix('css/app.css')}}" type="text/css">
    @else
        <link rel="stylesheet" href="{{mix('css/legacy.css')}}" type="text/css">
    @endif
@endpush

@prepend('scripts')
    @if(!isset($legacy) || $legacy === false)
        <script src="{{mix('js/app.js')}}"></script>
    @endif
@endprepend('scripts')

@push('scripts')
    <script src="https://kit.fontawesome.com/1aebffb7ee.js" crossorigin="anonymous"></script>
    @include('templates.cookies')
@endpush

@push('meta-tags')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
