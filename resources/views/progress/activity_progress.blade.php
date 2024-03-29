@extends('layouts.legacy')

@section('title', 'Progress of ' . $activity->name)

@section('app-content')
    <div class="container-fluid" style="text-align: center">
        <div class="row" style="padding-top: 7px;">
            <div class="col-md-12" style="text-align: center;">
                <h1>Progress through {{$activity->name}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <activity-progress :activity-id="{{$activity->id}}" activity-name="{{$activity->name}}"></activity-progress>
            </div>
        </div>
    </div>


@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
