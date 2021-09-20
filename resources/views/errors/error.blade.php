@extends('layouts.app')

@section('title', 'An error occured')

@section('app-content')
    <p-page-content
        class="text-center"
        title="Whoops!"
        subtitle="Something went wrong | Code {{method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $exception->getCode()}}">

        @if($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException)
            {{$exception->getMessage()}}
        @endif

        <hr class="border-0 bg-gray-500 text-gray-500 h-px my-3">

        If this error persists, please contact us for help at <a href="mailto:bristol-su@bristol.ac.uk">bristol-su@bristol.ac.uk.</a>

        <p-button type="secondary" href="{{route(request()->is(['a', 'a/*']) ? 'admin' : 'participant')}}">Take me
            home
        </p-button>
    </p-page-content>
@endsection
