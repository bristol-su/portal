@extends('layouts.app')

@section('title', 'Assign Permissions')

@section('app-content')

    <site-permission
        :permission="{{$permission}}">

    </site-permission>

@endsection
