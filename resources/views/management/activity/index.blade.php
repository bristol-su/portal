@extends('layouts.legacy')

@section('title', 'All Activities')

@section('app-content')
    <activity-index
        @can('view-management')
            :can-delete=true
        @endcan
        :activities="{{$activities}}">

    </activity-index>
@endsection


