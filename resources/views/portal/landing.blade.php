@extends('layouts.app')

@section('title', 'Welcome')

@section('app-content')
    <p-featured-card
        title="Bristol SU Portal"
        subtext="{{ \App\Settings\Appearance\Messaging\LandingPageTitle::getValue() }}"
        bg="landing-page"
    >
        <p-button class="w-full px-16 py-2 my-2 text-base font-medium text-blueGray-600 transition duration-500 ease-in-out transform rounded-md border-blueGray-50 bg-blueGray-50 focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-blueGray-100" href="{{route('login')}}">
            Login
        </p-button>
        <p-button class="w-full px-16 py-2 my-2 text-base font-medium text-white transition duration-500 ease-in-out transform border-black rounded-md bg-black focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-blueGray-900" href="{{route('register')}}">
            Register
        </p-button>
    </p-featured-card>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
