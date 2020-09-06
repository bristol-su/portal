@extends('bristolsu::base')

@section('title', 'Control')

@section('content')
    <div id="control-management"></div>
@endsection


@push('scripts')
    <script src="{{webpack('control.js')}}"></script>
@endpush
