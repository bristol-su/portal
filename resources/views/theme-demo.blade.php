<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Theme Demo</title>
</head>
<body>

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

<hr/>

<x-theme-button variant="info">
    Test
</x-theme-button>

<hr/>

<x-theme-spinner variant="info" size="lg" alt="Loading...">

</x-theme-spinner>
<x-theme-spinner variant="info" alt="Loading...">

</x-theme-spinner>

<hr/>

<x-theme-toggle id="testComponent" name="testComponent">
    This is the test toggle
</x-theme-toggle>

<hr/>

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
        :disabled="true"
        :validated="false"
        :required="true"
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
        id="some-other-select-3"
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

<hr/>

<x-theme-fieldset legend="Checkboxes!!">

    <x-theme-checkbox
        id="some-checkbox"
        name="my-checkbox"
        label="This is my checkbox"
        help="First checkbox!"
        sr-label="A checkbox for the demo page. This can only be seen by screen readers."
        :errors="[]"
        :disabled="true"
        :validated="false"
        value="test1"
        :checked="true">

    </x-theme-checkbox>

    <x-theme-checkbox
        id="some-checkbox-2"
        name="my-checkbox-2"
        label="This is my checkbox 2"
        help="Second checkbox!"
        sr-label="Another checkbox for the demo page. This can only be seen by screen readers."
        :errors="['First error', 'Maybe a second error too']"
        :validated="true"
        value="test2"
        :required="true"
        :checked="false">

    </x-theme-checkbox>

    <x-theme-checkbox
        id="some-checkbox-3"
        name="my-checkbox-3"
        label="This is my checkbox 3"
        help="Third checkbox!"
        sr-label="A third checkbox for the demo page. This can only be seen by screen readers."
        :errors="[]"
        :validated="true"
        value="test3"
        :required="false"
        :checked="true">
    </x-theme-checkbox>
</x-theme-fieldset>


<hr/>

<x-theme-fieldset legend="Select a radio">


<x-theme-radio
    id="some-radio"
    name="my-radio"
    label="This is my radio"
    help="First radio!"
    sr-label="A radio for the demo page. This can only be seen by screen readers."
    :errors="[]"
    :validated="false"
    value="test1"
    :checked="true">

</x-theme-radio>

<x-theme-radio
    id="some-radio-2"
    name="my-radio"
    label="This is my radio 2"
    help="Second radio!"
    sr-label="Another radio for the demo page. This can only be seen by screen readers."
    :errors="['First error', 'Maybe a second error too']"
    :validated="true"
    value="test2"
    :required="true"
    :checked="false">

</x-theme-radio>

<x-theme-radio
    id="some-radio-3"
    name="my-radio"
    label="This is my radio 3"
    help="Third radio!"
    sr-label="A third radio for the demo page. This can only be seen by screen readers."
    :errors="[]"
    :validated="true"
    value="test3"
    :required="false"
    :checked="true">
</x-theme-radio>
</x-theme-fieldset>

<hr/>

<x-theme-text
    id="some-text"
    name="my-text"
    label="This is my text input"
    help="Can't type anything in, it's a disabled element!"
    sr-label="A text for the demo page. This can only be seen by screen readers."
    :errors="[]"
    :disabled="true"
    :validated="false"
    :required="true"
    value="The default input"
>

</x-theme-text>

<x-theme-text
    id="some-other-text"
    name="my-text-2"
    label="A text with errors"
    help="This text has errors for validation"
    sr-label="A text with errors for the demo page. This can only be seen by screen readers."
    :errors="['This is the first error', 'And this is the second!']"
    :validated="true"
>

</x-theme-text>

<x-theme-text
    id="some-other-text-3"
    name="my-text-3"
    label="This is a valid text"
    help="This text has no errors, but has been validated"
    sr-label="Something or other here."
    :errors="[]"
    :validated="true"
>
</x-theme-text>

<hr/>

<x-theme-email
    id="some-email"
    name="my-email"
    label="This is my email input"
    help="Can't type anything in, it's a disabled element!"
    sr-label="A email for the demo page. This can only be seen by screen readers."
    :errors="[]"
    :disabled="true"
    :validated="false"
    :required="true"
    value="The default input"
>

</x-theme-email>

<x-theme-email
    id="some-other-email"
    name="my-email-2"
    label="A email with errors"
    help="This email has errors for validation"
    sr-label="A email with errors for the demo page. This can only be seen by screen readers."
    :errors="['This is the first error', 'And this is the second!']"
    :validated="true"
>

</x-theme-email>

<x-theme-email
    id="some-other-email-3"
    name="my-email-3"
    label="This is a valid email"
    help="This email has no errors, but has been validated"
    sr-label="Something or other here."
    :errors="[]"
    :validated="true"
>

</x-theme-email>

<hr/>

<x-theme-password
    id="some-password"
    name="my-password"
    label="This is my password input"
    help="Can't type anything in, it's a disabled element!"
    sr-label="A password for the demo page. This can only be seen by screen readers."
    :errors="[]"
    :disabled="true"
    :validated="false"
    :required="true"
    value="The default input"
>

</x-theme-password>

<x-theme-password
    id="some-other-password"
    name="my-password-2"
    label="A password with errors"
    help="This password has errors for validation"
    sr-label="A password with errors for the demo page. This can only be seen by screen readers."
    :errors="['This is the first error', 'And this is the second!']"
    :validated="true"
>

</x-theme-password>

<x-theme-password
    id="some-other-password-3"
    name="my-password-3"
    label="This is a valid password"
    help="This password has no errors, but has been validated"
    sr-label="Something or other here."
    :errors="[]"
    :validated="true"
>

</x-theme-password>

<hr/>

@foreach([[true,true], [false,true], [true,false], [false,false]] as $vals)
    <x-theme-list-group
        :bordered="$vals[0]"
        :horizontal="$vals[1]">

        <x-theme-list-item
            :active="true"
            :disabled="false"
            href="/test"
            variant="info">
            Item 1
        </x-theme-list-item>

        <x-theme-list-item
            :active="false"
            :disabled="false"
            href="/test2"
            variant="warning">
            Item 2
        </x-theme-list-item>

        <x-theme-list-item
            :active="false"
            :disabled="true"
            variant="danger">
            Item 3
        </x-theme-list-item>

        <x-theme-list-item
            :active="false"
            :disabled="false"
            href="/test3">
            Item 4
        </x-theme-list-item>

    </x-theme-list-group>
    <br />

@endforeach


<hr />

<x-theme-card>
    <x-slot name="image">
        <img src="https://hatrabbits.com/wp-content/uploads/2017/01/random.jpg" />
    </x-slot>
    <x-slot name="title">
        A title for the card
    </x-slot>
    <x-slot name="subtitle">
        A subtitle
    </x-slot>
    <x-slot name="body">
        This is some body. We can use any other components we want here!
    </x-slot>
    <x-slot name="actions">
        <x-theme-link href="#">Go here</x-theme-link>
        <x-theme-link href="#">Or here!</x-theme-link>
    </x-slot>

</x-theme-card>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

@include('theme::styles')
@include('theme::scripts')

</body>
</html>
