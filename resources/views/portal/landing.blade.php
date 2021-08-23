@extends('layouts.app')

@section('title', 'Welcome')

@section('app-content')
    <p-featured-card
        title="Bristol SU Portal"
        subtext="{{ \App\Settings\Appearance\Messaging\LandingPageTitle::getValue() }}"
        bg="landing-page"
    >
        <p-button variant="white" href="{{route('login')}}">
            Login
        </p-button>
        <p-button variant="black" href="{{route('register')}}">
            Register
        </p-button>
    </p-featured-card>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
