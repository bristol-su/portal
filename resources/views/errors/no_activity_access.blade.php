@extends('layouts.app')

@section('title', 'No Access')

@section('app-content')
    <div id="portal">
        <div class="py-5" id="vue-root">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="text-align: center">Access to {{$activity->name}} denied</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <h3>You don't appear to have access to {{$activity->name}}. If you believe this to be a mistake, please contact us.</h3>
                    </div>
                </div>
                <br/>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
