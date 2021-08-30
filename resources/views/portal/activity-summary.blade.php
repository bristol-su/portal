@extends('layouts.app')

@section('title', $title)

@section('app-content')
    <p-page-content title="{{$title}}" subtitle="{{$subtitle}}">
        @foreach($activities as $activity)
            <p-card
            title="{{$activity->name}}"
            subtitle="{{$activity->description}}"
            image-url="{{($activity->image_url ?? 'https://picsum.photos/720/400')}}"
            url="{{route('participant.activity', ['activity_slug' => $activity->slug])}}?{{$authQuery}}"
            url-text="Continue Activity"
            :progress="{{$evaluations[$activity->id]['percentage']}}"
            :total-tasks="{{$evaluations[$activity->id]['totalCount']}}"
            :tasks-complete="{{$evaluations[$activity->id]['completeCount']}}"
            ></p-card>
        @endforeach
    </p-page-content>
{{--    <div id="portal">--}}
{{--        <div class="py-5" id="vue-root">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <h2 style="text-align: center">{{$activity->name}}  @if($admin)- Admin @endif</h2>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr/>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-3">--}}
{{--                        <activity-sidebar--}}
{{--                            :activities="{{$activities}}"--}}
{{--                            :current-activity="{{$activity}}"--}}
{{--                            :admin="{{($admin?'true':'false')}}"--}}
{{--                        >--}}
{{----}}
{{--                        </activity-sidebar>--}}
{{----}}
{{--                    </div>--}}
{{--                    <div class="col-md-9">--}}
{{--                        <module-instances--}}
{{--                            :activity="{{$activity}}"--}}
{{--                            :admin="{{($admin?'true':'false')}}"--}}
{{--                            :evaluation="{{$evaluation}}"--}}
{{--                            :groupings="{{\BristolSU\Support\ModuleInstance\ModuleInstanceGrouping::forActivity($activity)->get()}}">--}}
{{----}}
{{--                        </module-instances>--}}
{{----}}
{{--                        @if($activity->type === 'multi-completable' && ! $admin)--}}
{{--                            <activity-instance-switcher--}}
{{--                                :current-activity-instance="{{$activityInstance}}"--}}
{{--                                :activity-instances="{{$activityInstances}}"></activity-instance-switcher>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br/>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @dd($activities)--}}

@endsection
