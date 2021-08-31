@extends('layouts.app')

@section('title', $logic->name)

@section('app-content')

    <logic-show
        :logic="{{$logic}}">

    </logic-show>

@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
