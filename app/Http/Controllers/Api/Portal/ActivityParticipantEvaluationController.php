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
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\Evaluation;
use BristolSU\Support\ModuleInstance\Facade\ModuleInstanceEvaluator;
use BristolSU\Support\Progress\ModuleInstanceProgress;
use BristolSU\Support\Progress\Progress;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;

class ActivityParticipantEvaluationController extends Controller
{
    public function user(ActivityRepositoryContract $activityRepository, Authentication $authentication, Activity $activity)
    {
        if(!LogicTester::evaluate($activity->forLogic, $authentication->getUser())) {
            throw new AuthorizationException('You are not a part of the ' . $activity->name . ' activity.');
        }
        return $this->evaluateActivity($activity, 'user', $authentication->getUser()->id());
    }

    public function group(ActivityRepositoryContract $activityRepository, Authentication $authentication, Activity $activity)
    {
        if(!LogicTester::evaluate($activity->forLogic, $authentication->getUser(), $authentication->getGroup())) {
            throw new AuthorizationException('You are not a part of the ' . $activity->name . ' activity.');
        }
        return $this->evaluateActivity($activity, 'group', $authentication->getRole()->id());
    }

    public function role(ActivityRepositoryContract $activityRepository, Authentication $authentication, Activity $activity)
    {
        if(!LogicTester::evaluate($activity->forLogic, $authentication->getUser(), $authentication->getGroup(), $authentication->getRole())) {
            throw new AuthorizationException('You are not a part of the ' . $activity->name . ' activity.');
        }
        return $this->evaluateActivity($activity, 'role', $authentication->getRole()->id());
    }

    private function evaluateActivity(Activity $activity, string $resourceType, int $resourceId)
    {
        if($activity->activity_for === 'role') {
            $resource = app(Authentication::class)->getRole();
        } else if($activity->activity_for === 'group') {
            $resource = app(Authentication::class)->getGroup();
        } else {
            $resource = app(Authentication::class)->getUser();
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
