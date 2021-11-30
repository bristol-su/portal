<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Logic\Audience\Audience;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LogIntoAdminController extends Controller
{

    public function show(Request $request, Activity $activity, Authentication $authentication)
    {
        $user = $authentication->getUser();
        $audienceMember = Audience::audience($activity->adminLogic, $user);

        $canBeUser = ($activity->activity_for === 'user' && $audienceMember->canBeUser());
        $groups = ($activity->activity_for !== 'role' ? $audienceMember->groups() : collect());

        if(!$canBeUser && $groups->isEmpty() && $audienceMember->roles()->isEmpty()) {
            $exception = new HttpException(403, 'You must be an admin to access this page');
            return view('errors.error')->with('exception', $exception);
        }

        return view('auth.resource-login')->with([
            'admin' => true,
            'user' => $user,
            'canBeUser' => $canBeUser,
            'groups' => $groups,
            'roles' => $audienceMember->roles(),
            'activity' => $activity,
            'redirectTo' => $request->input('redirect')
        ]);
    }

}
