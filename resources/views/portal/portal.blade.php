@extends('layouts.app')

@section('app-content')
    <div class="container-fluid" style="text-align: center">

    <toggle-admin-or-participant
    :admin="{{($administrator?'true':'false')}}">

    </toggle-admin-or-participant>

    <activities
        :activities="{{json_encode($activities)}}"
        :admin="{{($administrator?'true':'false')}}"
        :role-group="{{json_encode($roleGroupRelations)}}"
        :user-id="{{app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser()->id()}}"
        :roles="{{$roles->toJson()}}"
        :groups="{{$groups->toJson()}}">
    </activities>

    </div>

@endsection
