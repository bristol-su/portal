<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ActivityInstanceEvaluator;
use BristolSU\Support\Authentication\Contracts\ResourceIdGenerator;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ModuleInstanceEvaluator;
use BristolSU\Support\ModuleInstance\ModuleInstance;

class ActivityController extends Controller
{

    public function administrator(Activity $activity, Authentication $authentication)
    {
        $moduleInstances = collect();
        $activity->moduleInstances->each(function(ModuleInstance $moduleInstance) use (&$moduleInstances, $authentication) {
            $moduleInstances->push([
                'moduleInstance' => $moduleInstance,
                'grouping' => optional($moduleInstance->grouping)->id ?? 0,
                'header' => optional($moduleInstance->grouping)->heading ?? '',
                'evaluation' => app(ModuleInstanceEvaluator::class)->evaluateAdministrator(
                    $moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole()
                )
            ]);

        });
        return view('portal.activity')->with([
            'activity' => $activity->load('moduleInstances'),
            'admin' => true,
            'moduleInstances' => $moduleInstances
        ]);
    }

    public function participant(Activity $activity, ActivityInstance $activityInstance, Authentication $authentication)
    {
        $resourceType = $activity->activity_for;
        $resourceId = app(ResourceIdGenerator::class)->fromString($resourceType);


        $moduleInstances = collect();
        $activity->moduleInstances->each(function(ModuleInstance $moduleInstance) use (&$moduleInstances, $authentication, $activityInstance) {
            $moduleInstances->push([
                'moduleInstance' => $moduleInstance,
                'grouping' => optional($moduleInstance->grouping)->id ?? 0,
                'header' => optional($moduleInstance->grouping)->heading ?? '',
                'evaluation' => app(ModuleInstanceEvaluator::class)->evaluateParticipant(
                    $activityInstance, $moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole()
                )
            ]);

        });
        return view('portal.activity')->with([
            'activity' => $activity,
            'activityInstance' => $activityInstance,
            'activityInstances' => app(ActivityInstanceRepository::class)->allFor($activity->id, $resourceType, $resourceId),
            'admin' => false,
            'moduleInstances' => $moduleInstances
        ]);
    }

}
