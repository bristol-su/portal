@extends('layouts.portal')

@section('title', 'Portal')

@section('app-content')
    <p-portal
        :admin="{{request()->is('a/*') ? 'true' : 'false'}}">

    </p-portal>
@endsection
