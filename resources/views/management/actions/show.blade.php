@extends('layouts.app')

@section('title', $action->name)

@section('app-content')

    <action-show
        :action="{{$action}}">

    </action-show>

@endsection
