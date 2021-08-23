@extends('layouts.app')

@section('title', 'Create Module Instance')

@section('app-content')

    <module-instance-create
        :activity="{{$activity}}"
        for-logic="{{$activity->activity_for}}">

    </module-instance-create>

@endsection
