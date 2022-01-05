@extends('layouts.app')

@section('title', 'All Activities')

@section('app-content')
    <p-page-content title="Activities" subtitle="See all activities set up on the portal">
        <activity-index
            @can('view-management')
            :can-delete=true
            @endcan
            :activities="{{$activities}}">

        </activity-index>
    </p-page-content>
@endsection


