@extends('layouts.app')

@section('title', 'All Logic')

@section('app-content')

    <logic-index
    :logics="{{$logics}}">

    </logic-index>

@endsection
