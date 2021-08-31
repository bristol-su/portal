@extends('layouts.legacy')

@section('title', $logic->name)

@section('app-content')

    <logic-show
        :logic="{{$logic}}">

    </logic-show>

@endsection


