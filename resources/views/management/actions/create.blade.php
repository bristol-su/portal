@extends('layouts.legacy')

@section('title', 'Add an Action')

@section('app-content')

    <action-create
        :module-instance="{{$moduleInstance}}">

    </action-create>

@endsection


