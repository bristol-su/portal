<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Logic\Contracts\Audience\AudienceMemberFactory;
use Illuminate\Support\Facades\Response;

class PortalController extends Controller
{

    public function portal()
    {
        return Response::redirectTo('p');
    }

    public function participant(ActivityRepositoryContract $activityRepository, UserRepository $userRepository, Authentication $authentication)
    {
        $user = $authentication->getUser();
        $activities = ['role' => [], 'group' => [], 'user' => []];
        $roleGroupRelations = [];
        $roles = collect();
        $groups = collect();

        $activities['user'] = collect($activityRepository->getForParticipant($user))->filter(function($activity) {
            return $activity->activity_for !== 'group' && $activity->activity_for !== 'role';
        });

        foreach ($user->groups() as $group) {
            $groups->put($group->id(), $group);
            $activities['group'][$group->id()] = collect($activityRepository->getForParticipant($user, $group, null))->filter(function($activity) {
                return $activity->activity_for !== 'role';
            });
        }

        foreach ($user->roles() as $role) {
            $group = $role->group();
            $roles->put($role->id(), $role);
            $groups->put($group->id(), $group);
            $roleGroupRelations[$role->id()] = $group->id();
            $activities['role'][$role->id()] = $activityRepository->getForParticipant($user, $group, $role);
        }

        return view('portal.portal')->with([
            'activities' => $activities,
            'administrator' => false,
            'roleGroupRelations' => $roleGroupRelations,
            'roles' => $roles,
            'groups' => $groups
        ]);
    }

    public function administrator(ActivityRepositoryContract $activityRepository, Authentication $authentication)
    {
        $activities = ['role' => [], 'group' => [], 'user' => []];
        $roleGroupRelations = [];
        $roles = collect();
        $groups = collect();

        $user = $authentication->getUser();
        $activities['user'] = $activityRepository->getForAdministrator($user);


        foreach ($user->groups() as $group) {
            $groups->put($group->id(), $group);
            $activities['group'][$group->id] = $activityRepository->getForAdministrator($user, $group, null);
        }

        foreach ($user->roles() as $role) {
            $group = $role->group();
            $roles->put($role->id(), $role);
            $groups->put($group->id(), $group);
            $roleGroupRelations[$role->id()] = $group->id();
            $activities['role'][$role->id] = $activityRepository->getForAdministrator($user, $group, $role);
        }

        return view('portal.portal')->with([
            'activities' => $activities,
            'administrator' => true,
            'roleGroupRelations' => $roleGroupRelations,
            'roles' => $roles,
            'groups' => $groups
        ]);
    }

}

