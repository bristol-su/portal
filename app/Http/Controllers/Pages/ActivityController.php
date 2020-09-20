<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Authentication\Contracts\ResourceIdGenerator;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ActivityInstanceEvaluator;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ModuleInstanceEvaluator;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Support\Facades\Response;

class ActivityController extends Controller
{

    public function participant(Authentication $authentication, Activity $activity, ActivityInstance $activityInstance)
    {
        $resourceType = $activity->activity_for;
        $resourceId = app(ResourceIdGenerator::class)->fromString($resourceType);

        return view('portal.activity')->with([
            'activity' => $activity->load('moduleInstances'),
            'activityInstance' => $activityInstance,
            'activityInstances' => app(ActivityInstanceRepository::class)->allFor($activity->id, $resourceType, $resourceId),
            'admin' => false,
            'evaluation' => collect(app(ActivityInstanceEvaluator::class)->evaluateParticipant($activityInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole()))
        ]);
    }

    public function administrator(Authentication $authentication, Activity $activity)
    {
        $evaluation = collect();
        $activity->moduleInstances->each(function(ModuleInstance $moduleInstance) use (&$evaluation, $authentication) {
            $evaluation->put($moduleInstance->id(), app(ModuleInstanceEvaluator::class)->evaluateAdministrator(
                $moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole()
            ));
        });
        return view('portal.activity')->with([
            'activity' => $activity->load('moduleInstances'),
            'admin' => true,
            'evaluation' => $evaluation
        ]);
    }

}

