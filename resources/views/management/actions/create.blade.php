@extends('layouts.app')

@section('title', 'Add an Action')

@section('app-content')

    <p-page-content
        title="Actions for {{$moduleInstance->name}}"
        subtitle="Add and update actions for your module."
    >

        <action-create
            :module-instance="{{$moduleInstance}}"
            :module="{{$module}}">

        </action-create>

    </p-page-content>



@endsection


