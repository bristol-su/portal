<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Support\ActivityEvaluator;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivitySummaryController extends Controller
{

    public function user(Authentication $authentication, ActivityRepository $activityRepository)
    {
        $activities = $activityRepository->getForParticipant($authentication->getUser())
            ->filter(fn(Activity $activity) => $activity->activity_for !== 'group' && $activity->activity_for !== 'role');

        return view('portal.activity-summary')
            ->with('activities', $activities)
            ->with('title', 'Activities for you')
            ->with('subtitle', 'These are activities that pertain to you. You won\'t find your society activities here')
            ->with('evaluations', app(ActivityEvaluator::class)->evaluateMany($activities));
    }

    public function group(Group $group, Authentication $authentication, ActivityRepository $activityRepository)
    {
        if ($authentication->getUser()->groups()->filter(fn(Group $userGroup) => $userGroup->id() === $group->id())->isEmpty()) {
            throw new ModelNotFoundException(sprintf('Group with an ID of %s was not found or you are not in the group', $group->id()));
        }

        $activities = $activityRepository->getForParticipant($authentication->getUser(), $group)
            ->filter(fn(Activity $activity) => $activity->activity_for !== 'role');
        return view('portal.activity-summary')
            ->with('activities', $activities)
            ->with('title', 'Activities for ' . $group->data()->name())
            ->with('subtitle', 'These are activities that pertain to your membership to ' . $group->data()->name())
            ->with('evaluations', app(ActivityEvaluator::class)->evaluateMany($activities));
    }

    public function role(Role $role, Authentication $authentication, ActivityRepository $activityRepository)
    {
        if ($authentication->getUser()->roles()->filter(fn(Role $userRole) => $userRole->id() === $role->id())->isEmpty()) {
            throw new ModelNotFoundException(sprintf('Role with an ID of %s was not found or you are not in the role', $role->id()));
        }

        $activities = $activityRepository->getForParticipant($authentication->getUser(), $role->group(), $role);
        return view('portal.activity-summary')
            ->with('activities', $activities)
            ->with('title', 'Activities for ' . $role->data()->roleName() . ' of ' . $role->group()->data()->name())
            ->with('subtitle', 'These are activities that pertain to your position of ' . $role->data()->roleName() . ' in ' . $role->group()->data()->name())
            ->with('evaluations', app(ActivityEvaluator::class)->evaluateMany($activities));
    }

}
