@extends('layouts.legacy')

@section('title', 'Assign Permissions')

@section('app-content')

    <site-permission
        :permission="{{$permission}}">

    </site-permission>

@endsection


