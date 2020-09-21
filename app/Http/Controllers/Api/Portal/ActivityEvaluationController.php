<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Logic\Facade\LogicTester;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ActivityInstanceEvaluator;
use Illuminate\Auth\Access\AuthorizationException;

class ActivityEvaluationController extends Controller
{
    public function resource(ActivityRepositoryContract $activityRepository, Authentication $authentication, Activity $activity)
    {
        if(!LogicTester::evaluate($activity->forLogic, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole())) {
            throw new AuthorizationException('You are not a part of the ' . $activity->name . ' activity.');
        }
        if($activity->activity_for === 'role') {
            $resource = app(Authentication::class)->getRole();
        } else if($activity->activity_for === 'group') {
            $resource = app(Authentication::class)->getGroup();
        } else {
            $resource = app(Authentication::class)->getUser();
        }
        if($resource === null) {
            throw new AuthorizationException(sprintf('You must be logged into the correct resource type (%s)', $activity->activity_for));
        }

        $activityInstance = app(DefaultActivityInstanceGenerator::class)->generate($activity, $activity->activity_for, (string) $resource->id());
        $evaluations = app(ActivityInstanceEvaluator::class)->evaluateResource($activityInstance);

        $percentage = 0;
        $complete = true;
        $moduleCount = 0;

        foreach($evaluations as $evaluation) {
            if($evaluation->mandatory()) {
                $moduleCount++;
                $percentage += $evaluation->percentage();
                if(!$evaluation->complete()) {
                    $complete = false;
                }
            }
        }

        return [
            'percentage' => ($moduleCount > 0 ? ($percentage / $moduleCount) : 0),
            'complete' => $complete
        ];
    }

}
