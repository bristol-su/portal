<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\Support\Authentication\Contracts\Authentication;

class ActivityAdminController extends Controller
{

    public function user(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $user = $authentication->getUser();
        return collect($activityRepository->getForAdministrator($user))->filter(function($activity) {
            return $activity->activity_for !== 'group' && $activity->activity_for !== 'role';
        });
    }

    public function group(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $group = $authentication->getGroup();
        return collect($activityRepository->getForAdministrator($authentication->getUser(), $group))->filter(function($activity) {
            return $activity->activity_for !== 'role';
        });
    }

    public function role(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $role = $authentication->getRole();
        return collect($activityRepository->getForAdministrator($authentication->getUser(), $role->group(), $role));
    }

}
