<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\Logic\Contracts\Audience\AudienceMemberFactory;
use Illuminate\Http\Request;

class LogIntoParticipantController extends Controller
{

    public function show(Request $request, Activity $activity, AudienceMemberFactory $factory, UserAuthentication $userAuthentication)
    {
        $user = $userAuthentication->getUser()->controlUser();
        $audienceMember = $factory->fromUser($user);
        $audienceMember->filterForLogic($activity->forLogic);

        if(!$audienceMember->hasAudience()) {
            return view('errors.no_activity_access')->with([
                'admin' => false,
                'activity' => $activity
            ]);
        }

        return view('auth.login.resource')->with([
            'admin' => false,
            'user' => $user,
            'canBeUser' => $audienceMember->canBeUser(),
            'groups' => $audienceMember->groups(),
            'roles' => $audienceMember->roles(),
            'activity' => $activity,
            'redirectTo' => $request->input('redirect')
        ]);
    }

}
