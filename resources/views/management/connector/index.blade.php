@extends('layouts.app')

@section('title', 'Connectors')

@section('app-content')
    <connector-index>

    </connector-index>

@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
