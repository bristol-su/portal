@extends('layouts.app')

@section('title', 'Action ' . $action->name)

@section('app-content')

    <p-page-content
        title="Action {{$action->name}}"
        subtitle="Update the action"
    >

        <action-create
            :module-instance="{{$moduleInstance}}"
            :module="{{$module}}"
            :action-instance="{{$action}}">

        </action-create>

    </p-page-content>



@endsection


