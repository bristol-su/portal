<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\Evaluation;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ModuleInstanceEvaluator;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstance;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;

class ModuleInstanceEvaluationController extends Controller
{

    public function participant(Activity $activity, ModuleInstanceRepository $moduleInstanceRepository, ActivityInstanceResolver $activityInstanceResolver, Authentication $authentication)
    {
        $activityInstance = $activityInstanceResolver->getActivityInstance();
        return $moduleInstanceRepository->allThroughActivity($activity)->map(function(ModuleInstance $moduleInstance) use ($activityInstance, $authentication) {
            $moduleInstanceArray = $moduleInstance->toArray();
            $moduleInstanceArray['evaluation'] = app(ModuleInstanceEvaluator::class)->evaluateParticipant($activityInstance, $moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole())->toArray();
            return $moduleInstanceArray;
        })->filter(function($moduleInstanceArray) {
            return $moduleInstanceArray['evaluation']['visible'];
        });
    }

    public function resource(Activity $activity, ModuleInstanceRepository $moduleInstanceRepository, ActivityInstanceResolver $activityInstanceResolver, Authentication $authentication)
    {
        $activityInstance = $activityInstanceResolver->getActivityInstance();
        return $moduleInstanceRepository->allThroughActivity($activity)->map(function(ModuleInstance $moduleInstance) use ($activityInstance, $authentication) {
            $moduleInstanceArray = $moduleInstance->toArray();
            $moduleInstanceArray['evaluation'] = app(ModuleInstanceEvaluator::class)->evaluateResource($activityInstance, $moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole())->toArray();
            return $moduleInstanceArray;
        })->filter(function($moduleInstanceArray) {
            return $moduleInstanceArray['evaluation']['visible'];
        });
    }


    public function admin(Activity $activity, ModuleInstanceRepository $moduleInstanceRepository, Authentication $authentication)
    {
        return $moduleInstanceRepository->allThroughActivity($activity)->map(function(ModuleInstance $moduleInstance) use ($authentication) {
            $moduleInstanceArray = $moduleInstance->toArray();
            $moduleInstanceArray['evaluation'] = app(ModuleInstanceEvaluator::class)->evaluateAdministrator($moduleInstance, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole())->toArray();
            return $moduleInstanceArray;
        })->filter(function($moduleInstanceArray) {
            return $moduleInstanceArray['evaluation']['visible'];
        });
    }

}
