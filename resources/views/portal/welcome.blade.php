@extends('layouts.app')

@section('app-content')
    <welcome
        title="{{siteSetting('welcome.messages.title', 'Welcome to the portal!')}}"
        :registration="{{(siteSetting('welcome.fillInRegInformation', true)?'true':'false')}}"
        :data-user="{{app(\BristolSU\Support\User\Contracts\UserAuthentication::class)->getUser()->controlUser()->data()}}"
        subtitle="{{siteSetting('welcome.messages.subtitle', 'Before we start, check our records are up to date!')}}"
        :attributes="{{json_encode(siteSetting('welcome.attributes', []), JSON_FORCE_OBJECT)}}"></welcome>
@endsection
