<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use Illuminate\Support\Facades\Response;

class PortalController extends Controller
{

    public function portal()
    {
        return Response::redirectTo('p');
    }

    public function participant(ActivityRepositoryContract $activityRepository, UserRepository $userRepository, UserAuthentication $userAuthentication)
    {
        $user = $userRepository->getById($userAuthentication->getUser()->control_id);
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

        return view('pages.portal.portal')->with([
            'activities' => $activities,
            'administrator' => false,
            'roleGroupRelations' => $roleGroupRelations,
            'roles' => $roles,
            'groups' => $groups
        ]);
    }

    public function administrator(ActivityRepositoryContract $activityRepository, UserAuthentication $userAuthentication)
    {
        $activities = ['role' => [], 'group' => [], 'user' => []];
        $roleGroupRelations = [];
        $roles = collect();
        $groups = collect();

        $user = $userAuthentication->getUser()->controlUser();
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

        return view('pages.portal.portal')->with([
            'activities' => $activities,
            'administrator' => true,
            'roleGroupRelations' => $roleGroupRelations,
            'roles' => $roles,
            'groups' => $groups
        ]);
    }

}

