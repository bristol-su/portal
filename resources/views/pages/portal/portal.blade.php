@extends('layouts.portal')

@section('title', 'Portal')

@section('app-content')
    <p-activities-layout
        :admin="{{request()->is('a/*') ? 'true' : 'false'}}">

    </p-activities-layout>
@endsection