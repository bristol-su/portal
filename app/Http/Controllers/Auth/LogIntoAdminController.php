<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogIntoAdmin\LoginRequest;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepositoryContract;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\Support\Logic\Contracts\Audience\AudienceMemberFactory;
use BristolSU\Support\Logic\Contracts\LogicTester;
use Illuminate\Http\Request;

class LogIntoAdminController extends Controller
{

    public function show(Request $request, Activity $activity, AudienceMemberFactory $factory, UserRepository $userRepository, UserAuthentication $userAuthentication)
    {
        $user = $userRepository->getById($userAuthentication->getUser()->control_id);
        $audienceMember = $factory->fromUser($user);
        $audienceMember->filterForLogic($activity->adminLogic);

        if(!$audienceMember->hasAudience()) {
            return view('errors.no_activity_access')->with([
                'admin' => true,
                'activity' => $activity
            ]);
        }

        return view('auth.login.resource')->with([
            'admin' => true,
            'user' => $user,
            'canBeUser' => $audienceMember->canBeUser(),
            'groups' => $audienceMember->groups(),
            'roles' => $audienceMember->roles(),
            'activity' => $activity,
            'redirectTo' => $request->input('redirect')
        ]);
    }

    public function login(LoginRequest $request, Authentication $authentication)
    {
        // TODO Check the thing they want to log in as against the audience member in validation
        $loginId = $request->input('login_id');
        $loginType = $request->input('login_type');
        $user = app(UserRepository::class)->getById(app(UserAuthentication::class)->getUser()->control_id);

        $authentication->reset();

        switch($loginType) {
            case 'user':
                $authentication->setUser($user);
                break;
            case 'group':
                $authentication->setGroup(app(GroupRepository::class)->getById($loginId));
                $authentication->setUser($user);
                break;
            case 'role':
                $role = app(RoleRepository::class)->getById($loginId);
                $authentication->setRole($role);
                $authentication->setGroup($role->group());
                $authentication->setUser($user);
                break;
        }

        return redirect()->to($request->input('redirect', back()->getTargetUrl()));
    }

}
