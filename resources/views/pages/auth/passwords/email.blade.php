@extends('layouts.portal')

@section('title', 'Password Reset')

@section('app-content')
<p-password-email-form
    route="{{route('password.email')}}"
    status="{{session('status', null)}}">
</p-password-email-form>
@endsection
