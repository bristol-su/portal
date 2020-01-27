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
        $activities['user'] = collect($activityRepository->getForParticipant($user))->filter(function($activity) {
            return $activity->activity_for !== 'group' && $activity->activity_for !== 'role';
        });

        foreach ($user->groups() as $group) {
            $activities['group'][$group->id] = collect($activityRepository->getForParticipant($user, $group, null))->filter(function($activity) {
                return $activity->activity_for !== 'role';
            });
        }

        foreach ($user->roles() as $role) {
            $activities['role'][$role->id] = $activityRepository->getForParticipant($user, $role->group(), $role);
        }

        return view('portal.portal')->with([
            'activities' => $activities,
            'administrator' => false
        ]);
    }

    public function administrator(ActivityRepositoryContract $activityRepository, UserRepository $userRepository, UserAuthentication $userAuthentication)
    {
        $activities = ['role' => [], 'group' => [], 'user' => []];
        $user = $userRepository->getById($userAuthentication->getUser()->control_id);
        $activities['user'] = $activityRepository->getForAdministrator($user);


        foreach ($user->groups() as $group) {
            $activities['group'][$group->id] = $activityRepository->getForAdministrator($user, $group, null);
        }

        foreach ($user->roles() as $role) {
            $activities['role'][$role->id] = $activityRepository->getForAdministrator($user, $role->group(), $role);
        }

        return view('portal.portal')->with([
            'activities' => $activities,
            'administrator' => true
        ]);
    }

}

