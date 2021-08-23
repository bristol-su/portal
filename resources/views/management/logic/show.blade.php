@extends('layouts.app')

@section('title', $logic->name)

@section('app-content')

    <logic-show
        :logic="{{$logic}}">

    </logic-show>

@endsection
