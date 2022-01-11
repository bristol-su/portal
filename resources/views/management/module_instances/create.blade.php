@extends('layouts.app')

@section('title', 'Create Module Instance')

@section('app-content')

    <module-create
        :modules="{{json_encode($modules)}}"
        module-type="{{$moduleType ?? null}}"
        :activity="{{$activity}}"
        for-logic="{{$activity->activity_for}}">

    </module-create>

@endsection


