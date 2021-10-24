<?php


namespace App\Http\Controllers\Api\Relationships;


use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\Support\Logic\Audience\Audience;
use BristolSU\Support\Logic\Audience\AudienceMember;
use BristolSU\Support\Logic\Logic;

class LogicAudienceController extends Controller
{

    public function index(Logic $logic)
    {
        return collect(Audience::audience($logic))
            ->map(function(AudienceMember $audienceMember) {
                $array = $audienceMember->toArray();
                $array['roles'] = $audienceMember->roles()->map(
                    fn(Role $role) => array_merge($role->toArray(), ['position' => $role->position(), 'group' => $role->group()])
                );
                return $array;
            });
    }

    public function user(Logic $logic)
    {
        return Audience::getUsersInLogicGroup($logic);
    }

    public function group(Logic $logic)
    {
        return Audience::getGroupsInLogicGroup($logic);
    }

    public function role(Logic $logic)
    {
        return Audience::getRolesInLogicGroup($logic);
    }

}
