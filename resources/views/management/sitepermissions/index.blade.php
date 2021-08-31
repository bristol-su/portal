@extends('layouts.app')

@section('title', 'Permission Management')

@section('app-content')

    <site-permissions>

    </site-permissions>

@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush
