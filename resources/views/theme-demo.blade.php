@extends('layouts.portal')

@section('title', 'Theme Demo')

@section('app-content')

        <x-theme-alert variant="danger" :dismissible="true" name="top-of-page">
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

        <hr/>

        <form>
            <x-theme-select
                id="some-select"
                name="my-select"
                label="This is my select"
                help="Why not select an option?"
                sr-label="A select for the demo page. This can only be seen by screen readers."
                :errors="[]"
                :validated="false"
                :items="['item1' => 'Item 1', 'item2' => 'Item 2', 'Other' => ['item3' => 'Item 3', 'item4' => 'Item 4']]">

            </x-theme-select>

            <x-theme-select
                id="some-other-select"
                name="my-select-2"
                label="A select with errors"
                help="This select has errors for validation"
                sr-label="A select with errors for the demo page. This can only be seen by screen readers."
                :errors="['This is the first error', 'And this is the second!']"
                :validated="true"
                :items="['item1' => 'Item 1', 'item2' => 'Item 2', 'Other' => ['item3' => 'Item 3', 'item4' => 'Item 4']]">

            </x-theme-select>

            <x-theme-select
                id="some-other-select"
                name="my-select-3"
                label="This is a valid select"
                help="This select has no errors, but has been validated"
                sr-label="Something or other here."
                :errors="[]"
                :validated="true"
                :items="['item1' => 'Item 1', 'item2' => 'Item 2', 'Other' => ['item3' => 'Item 3', 'item4' => 'Item 4']]">

            </x-theme-select>
        </form>

    <hr/>

    <x-theme-error-summary
        :errors="$errors">

    </x-theme-error-summary>
@endsection
