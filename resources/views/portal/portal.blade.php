@extends('layouts.app')

@section('app-content')

    @if($activities['user']->count() > 0)
        <p-card-group title="Personal">
            <p-card
                title="Personal Activities"
                url="{{route(sprintf('summary.%s.user', $administrator ? 'a' : 'p')) }}"
                url-text="View"
            >
            </p-card>
        </p-card-group>
    @endif

    @if($groups->count() > 0)
        <p-card-group title="Student Group Memberships">
            @foreach($groups as $group)
                @if(isset($activities['group'][$group->id()]) && $activities['group'][$group->id()]->count() > 0)
                <p-card
                    title="Membership to {{$group->data()->name()}}"
                    url="{{route(sprintf('summary.%s.group', $administrator ? 'a' : 'p'), ['control_group' => $group->id()])}}"
                    url-text="View"
                >
                </p-card>
                @endif
            @endforeach
        </p-card-group>
    @endif

    @if($roles->count() > 0)
        <p-card-group title="Student Group Committee Roles">
            @foreach($roles as $role)
                @if(isset($activities['role'][$role->id()]) && $activities['role'][$role->id()]->count() > 0)
                    <p-card
                        title="{{($role->data()->roleName() ? $role->data()->roleName() : $role->position()->data()->name())}} of {{$role->group()->data()->name()}}"
                        url="{{route(sprintf('summary.%s.role', $administrator ? 'a' : 'p'), ['control_role' => $role->id()])}}"
                        url-text="View"
                    >
                    </p-card>
                @endif
            @endforeach
        </p-card-group>
    @endif

@endsection
