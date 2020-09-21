<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\Support\User\Contracts\UserAuthentication;

class OwnedResourceController extends Controller
{

    /**
     * Get resources the logged in user owns
     *
     * @param UserAuthentication $userAuthentication
     * @return array
     */
    public function index(UserAuthentication $userAuthentication)
    {
        $user = $userAuthentication->getUser()->controlUser();

        return [
            'user' => $user,
            'groups' => $user->groups(),
            'roles' => $user->roles()->map(function(Role $role) {
                $roleArray = $role->toArray();
                $roleArray['group'] = $role->group()->toArray();
                return $roleArray;
            })
        ];

    }

}
