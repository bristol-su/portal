@extends('bristolsu::base')

@section('title', 'Welcome')
@section('content')
    <div class="text-center py-5">
        <div class="container">
            <div class="row my-5 justify-content-center">
                <div class="col-md-9">
                    <h1>Bristol SU Portal</h1>
                    <p class="lead text-muted">
                        {!! \App\Settings\Appearance\Messaging\LandingPageTitle::getValue() !!}
                    </p>
                    {{--                    <a href="{{url('/login')}}" class="btn btn-primary m-2">Login</a>--}}
                    <a href="{{url('/register')}}" class="btn btn-lg btn-primary m-1">Register</a>
                    <a href="{{url('/login')}}" class="btn btn-lg btn-outline-secondary m-1">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
