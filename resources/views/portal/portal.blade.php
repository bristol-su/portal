@extends('layouts.app')

@section('app-content')
    <div class="container-fluid" style="text-align: center">

        Aidan: This page can be used temporarily as a 'dashboard' type thing. We want to ensure
        <ul>
            <li>Users know they can have multiple roles</li>
            <li>Users know they may have different activities under different roles</li>
            <li>Users know that because they've finished reaffiliation for one soc, they may still have it for another</li>
        </ul>
        <hr />
        <h1>Hey {{optional(app(\BristolSU\Support\Authentication\Contracts\Authentication::class)->getUser())->data()->preferredName()}},</h1>

        <p>Welcome to the Bristol SU Portal. Using this site, you can perform admin tasks for your groups. We're migrating
        processes across to this system, so expect to see more services soon.</p>


        <p>Any activities that are for you and only you (rather than on behalf of a group) are in your <a href="{{route(sprintf('summary.%s.user', $administrator ? 'a' : 'p'))}}">user account</a>. There are {{count($activities['user'])}} activities here.</p>

        <p>Any activities that are for your membership to a society can be found against the group.</p>

        <ul>
            @foreach($activities['group'] as $groupId => $groupActivities)
                <li><a href="{{route(sprintf('summary.%s.group', $administrator ? 'a' : 'p'), ['control_group' => $groupId])}}">{{$groups[$groupId]->data()->name()}} Membership</a>: {{count($groupActivities)}} activities</li>
            @endforeach
        </ul>

        <p>You also have activities for your role in a society.</p>

        <ul>
            @foreach($activities['role'] as $roleId => $roleActivities)
                <li><a href="{{route(sprintf('summary.%s.role', $administrator ? 'a' : 'p'), ['control_role' => $roleId])}}">{{$roles[$roleId]->data()->roleName()}} Role for {{$groups[$roles[$roleId]->groupId()]->data()->name()}}</a>: {{count($roleActivities)}} activities</li>
            @endforeach
        </ul>

    </div>

@endsection
