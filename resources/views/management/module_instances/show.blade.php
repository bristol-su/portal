@extends('layouts.legacy')

@section('title', $moduleInstance->name)

@section('app-content')

    <module-instance-show
        :module-instance="{{$moduleInstance}}">

    </module-instance-show>

@endsection


