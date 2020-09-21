@extends('layouts.portal')

@section('title', 'Portal')

@section('app-content')
    <p-activity-layout
        :activity="{{$activity}}"
        :admin="{{request()->is('a/*') ? 'true' : 'false'}}">

    </p-activity-layout>
@endsection
