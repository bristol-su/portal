<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ActivityInstanceEvaluator;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\Evaluation;
use BristolSU\Support\ModuleInstance\Facade\ModuleInstanceEvaluator;
use BristolSU\Support\Progress\ModuleInstanceProgress;
use BristolSU\Support\Progress\Progress;
use Carbon\Carbon;

class ActivityParticipantController extends Controller
{

    public function user(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $user = $authentication->getUser();
        return collect($activityRepository->getForParticipant($user))->filter(function($activity) {
            return $activity->activity_for !== 'group' && $activity->activity_for !== 'role';
        });
    }

    public function group(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $group = $authentication->getGroup();
        return collect($activityRepository->getForParticipant($authentication->getUser(), $group))->filter(function($activity) {
            return $activity->activity_for !== 'role';
        });
    }

    public function role(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $role = $authentication->getRole();
        return collect($activityRepository->getForParticipant($authentication->getUser(), $role->group(), $role));
    }

}
