@extends('layouts.legacy')

@section('title', $activity->name)

@section('app-content')
    <activity-show
        @can('view-management')
            :can-delete=true
        @endcan
        :activity="{{$activity}}">

    </activity-show>

@endsection


