@extends('layouts.legacy')

@section('title', $activity->name)

@section('app-content')

    <activity-show
        :activity="{{$activity}}">

    </activity-show>

@endsection


