@extends('layouts.app')

@section('title', 'All Activities')

@section('app-content')
    <activity-index
        :activities="{{$activities}}">

    </activity-index>
@endsection
