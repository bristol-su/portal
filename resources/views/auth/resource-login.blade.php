@extends('layouts.app')

@section('title', 'Activity Access')

@section('app-content')
    <p-page-content class="text-center"
        title="Login to activity"
        subtitle="Which role would you like to act as to complete the activity?">
        <log-into-resource
            :user="{{$user}}"
            :can-be-user="{{($canBeUser?'true':'false')}}"
            :groups="{{$groups}}"
            :roles="{{$roles}}"
            :activity="{{$activity}}"
            redirect-to="{{$redirectTo}}"
            :admin="{{($admin?'true':'false')}}">

        </log-into-resource>

        @if($canBeUser)
            <p-card-group title="Personal">
                <p-card
                    title="As Yourself"
                    url="{{ $redirectTo }}?u={{$user->id()}}"
                    url-text="Go"
                >
                </p-card>
            </p-card-group>
        @endif

        @if($groups->count() > 0)
            <p-card-group title="Student Group Memberships">
                @foreach($groups as $group)
                    <p-card
                        title="In your membership to {{$group->data()->name()}}"
                        url="{{ $redirectTo }}?u={{$user->id()}}&g={{$group->id()}}"
                        url-text="View"
                    >
                    </p-card>
                @endforeach
            </p-card-group>
        @endif

        @if($roles->count() > 0)
            <p-card-group title="Student Group Committee Roles">
                @foreach($roles as $role)
                    <p-card
                        title="As your position of {{($role->data()->roleName() ? $role->data()->roleName() : $role->position()->data()->name())}} to {{$role->group()->data()->name()}}"
                        url="{{ $redirectTo }}?u={{$user->id()}}&g={{$role->group()->id()}}&r={{$role->id()}}"
                        url-text="View"
                    >
                    </p-card>
                @endforeach
            </p-card-group>
        @endif

    </p-page-content>


@endsection
