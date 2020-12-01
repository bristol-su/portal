@extends('layouts.portal')

@section('title', 'Login')

@section('app-content')

        <x-theme-alert variant="danger" :dismissible="true">
            Uho, it looks like something went wrong! Give it another go :)
        </x-theme-alert>
        <x-theme-alert variant="success" :dismissible="true">
            Or maybe it went right!
        </x-theme-alert>
        <x-theme-alert variant="warning" :dismissible="true">
            Let's settle with being careful
        </x-theme-alert>
        <x-theme-alert variant="info" :dismissible="false">
            And keep us <a href="#">informed</a>
        </x-theme-alert>

        <hr />

        <x-theme-button variant="info">
            Test
        </x-theme-button>

        <hr />

        <x-theme-spinner variant="info" size="lg" alt="Loading...">

        </x-theme-spinner>
        <x-theme-spinner variant="info" alt="Loading...">

        </x-theme-spinner>

        <hr />

        <x-theme-toggle id="testComponent" name="testComponent">
            This is the test toggle
        </x-theme-toggle>

        <hr />

        <x-theme-link href="{{route('login')}}">
            This is a link to the same page!
        </x-theme-link>
@endsection
