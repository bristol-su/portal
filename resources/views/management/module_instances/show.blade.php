@extends('layouts.app')

@section('title', $moduleInstance->name)

@section('app-content')

    <p-page-content
        title="{{$moduleInstance->activity->name}} - {{$moduleInstance->name}}"
        subtitle="Update and see your module"
    >

        <module-show
            :module-instance="{{$moduleInstance}}"
            :module="{{$module}}"
            :activity="{{$activity}}">

        </module-show>

    </p-page-content>

@endsection


