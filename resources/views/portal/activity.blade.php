@extends('layouts.app')

@section('title', $activity->name)

@section('app-content')

    <p-page-content title="{{$activity->name}}  @if($admin)- Admin @endif"
                    @if($activity->type === 'multi-completable' && ! $admin)
                    subtitle="Tasks to complete {{$activityInstance->name}} ({{$activityInstance->created_at->format('d/m/y')}})"
                    @else
                    subtitle="Tasks to complete {{$activity->name}}"
        @endif
    >
        <template #actions>
            @if($activity->type === 'multi-completable' && ! $admin)
                <activity-instance-switcher
                    :current-activity-instance="{{$activityInstance}}"
                    :activity-instances="{{$activityInstances}}"></activity-instance-switcher>
            @endif
        </template>
        @foreach($moduleInstances->groupBy('grouping') as $groupedModuleInstances)
            <p-card-group title="{{$groupedModuleInstances[0]['header']}}">
                @foreach($groupedModuleInstances as $moduleInstance)
                    @if($moduleInstance['evaluation']->visible())
                        <p-card
                            title="{{$moduleInstance['moduleInstance']->name}}"
                            subtitle="{{$moduleInstance['moduleInstance']->description}}"
                            url="{{route(sprintf('module.%s', $admin ? 'admin' : 'participant'), ['activity_slug' => $activity->slug, 'module_instance_slug' => $moduleInstance['moduleInstance']->slug, url()->getAuthQueryString()])}}"
                            url-text="Continue Task"
                            :progress="{{$moduleInstance['evaluation']->percentage()}}"
                            :mandatory="{{($moduleInstance['evaluation']->mandatory() ? 'true' : 'false')}}"
                            :disabled="{{($moduleInstance['evaluation']->active() ? 'false' : 'true')}}"
                        ></p-card>
                    @endif
                @endforeach
            </p-card-group>
        @endforeach
    </p-page-content>

@endsection
