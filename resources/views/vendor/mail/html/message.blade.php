@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url'), 'imageUrl' => asset('/images/email-header.png')])
<img src="{{asset('/images/email-header.png')}}" alt="Reaffilation 2022/23">

@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

<img src="{{asset('/images/logo.png')}}" style="width: 100vw; max-width: 150px;" alt="Bristol SU Logo">

<p style="font-size: 14px;">
University of Bristol Students' Union,
The Richmond Building, 105 Queens Road,
Clifton, Bristol BS8 1LN
</p>

<p style="font-size: 14px;">
Charity #1139656  Company #6977417
</p>

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
