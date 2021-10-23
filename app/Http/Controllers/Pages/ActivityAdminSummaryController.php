<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepository;
use BristolSU\Support\Authentication\AuthQuery\AuthCredentials;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivityAdminSummaryController extends Controller
{

    public function user(Authentication $authentication, ActivityRepository $activityRepository)
    {
        $activities = $activityRepository->getForAdministrator($authentication->getUser());

        return view('portal.admin-activity-summary')
            ->with('activities', $activities)
            ->with('title', 'Your Activities')
            ->with('authQuery', (new AuthCredentials(null, null, null))->toQuery())
            ->with('subtitle', 'Here are your personal activities! To find activities for your society, go to dashboard and select the relevant card.');
    }

    public function group(Group $group, Authentication $authentication, ActivityRepository $activityRepository)
    {
        if($authentication->getUser()->groups()->filter(fn(Group $userGroup) => $userGroup->id() === $group->id())->isEmpty()) {
            throw new ModelNotFoundException(sprintf('Group with an ID of %s was not found or you are not in the group', $group->id()));
        }

        $activities = $activityRepository->getForAdministrator($authentication->getUser(), $group);

        return view('portal.admin-activity-summary')
            ->with('title', 'Your ' . $group->data()->name() . ' Activities')
            ->with('subtitle', 'Here are your ' . $group->data()->name() . ' membership activities.')
            ->with('authQuery', (new AuthCredentials($group->id(), null, null))->toQuery())
            ->with('activities', $activities);
    }

    public function role(Role $role, Authentication $authentication, ActivityRepository $activityRepository)
    {
        if($authentication->getUser()->roles()->filter(fn(Role $userRole) => $userRole->id() === $role->id())->isEmpty()) {
            throw new ModelNotFoundException(sprintf('Role with an ID of %s was not found or you are not in the role', $role->id()));
        }

        $activities = $activityRepository->getForAdministrator($authentication->getUser(), $role->group(), $role);

        return view('portal.admin-activity-summary')
            ->with('title', 'Activities for ' . ($role->data()->roleName() ? $role->data()->roleName() : $role->position()->data()->name()) . ' of ' . $role->group()->data()->name())
            ->with('subtitle', 'Here are your activities for your Admin position of ' . $role->data()->roleName() . ' in ' . $role->group()->data()->name())
            ->with('authQuery', (new AuthCredentials($role->groupId(), $role->id(), null))->toQuery())
            ->with('activities', $activities);
    }

}
