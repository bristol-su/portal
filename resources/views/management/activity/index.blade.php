@extends('layouts.legacy')

@section('title', 'All Activities')

@section('app-content')
    <activity-index
        :activities="{{$activities}}">

    </activity-index>
@endsection


