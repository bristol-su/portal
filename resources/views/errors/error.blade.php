@extends('layouts.app')

@section('title', 'An error occured')

@section('app-content')
    <p-error-page
        message="{{($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) ? $exception->getMessage() : ''}}"
        code="{{method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $exception->getCode()}}"
        email="bristol-su@bristol.ac.uk"
        home-url="{{route(request()->is(['a', 'a/*']) ? 'admin' : 'participant')}}"
    >

    </p-error-page>
@endsection
