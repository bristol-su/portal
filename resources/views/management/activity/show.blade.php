@extends('layouts.app')

@section('title', $activity->name)

@section('app-content')
    <p-page-content title="{{$activity->name}}" subtitle="Viewing information about {{$activity->name}}">
        <activity-show
            @can('view-management')
            :can-delete=true
            @endcan
            :activity="{{$activity}}">

        </activity-show>
    </p-page-content>

@endsection


