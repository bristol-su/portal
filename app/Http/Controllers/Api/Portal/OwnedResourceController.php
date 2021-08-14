<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\Support\Authentication\Contracts\Authentication;

class OwnedResourceController extends Controller
{

    /**
     * Get resources the logged in user owns
     *
     * @param Authentication $authentication
     * @return array
     */
    public function index(Authentication $authentication)
    {
        $user = $authentication->getUser();

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
