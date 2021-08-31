@extends('layouts.app')

@section('title', $action->name)

@section('app-content')

    <action-show
        :action="{{$action}}">

    </action-show>

@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
