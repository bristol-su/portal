@extends('layouts.app')

@section('title', 'Dashboard')

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

    @if($groups->filter(fn($group) => $activities['group'][$group->id()] ?? false)->count() > 0)
        <p-card-group title="Student Group Memberships">
            @foreach($groups as $group)
                @if(isset($activities['group'][$group->id()]) && $activities['group'][$group->id()]->count() > 0)
                <p-card
                    title="Membership to {{$group->data()->name()}}"
                    url="{{route(sprintf('summary.%s.group', $administrator ? 'a' : 'p'), ['control_group' => $group->id()])}}?g={{$group->id()}}"
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
                @if(isset($activities['role'][$role->id()]))
                    <p-card
                        title="{{($role->data()->roleName() ? $role->data()->roleName() : $role->position()->data()->name())}} of {{$role->group()->data()->name()}} ({{ $role->tags()->filter(fn(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $tag) => $tag->category()->reference() === 'committee_year')->first()?->name() ?? 'No Date' }})"
                        url="{{route(sprintf('summary.%s.role', $administrator ? 'a' : 'p'), ['control_role' => $role->id()])}}?r={{$role->id()}}&g={{$role->groupId()}}"
                        url-text="{{$activities['role'][$role->id()]->count() > 0 ? 'View' : 'No activities found'}}"
                    >
                    </p-card>
                @endif
            @endforeach
        </p-card-group>
    @endif

    @if($activities['user']->count() === 0 && $groups->count() === 0 && $roles->count() === 0)
        <div class="text-center">
            If you've been asked to complete an activity on the portal but can't see anything below, please contact us for help.
        </div>
    @endif
@endsection
