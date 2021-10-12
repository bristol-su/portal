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
        $items = collect(Audience::audience($logic));
        $itemCount = $items->count();

        $paginationItems = $this->getItemsToPaginate($items)
            ->map(fn(AudienceMember $audienceMember) => array_merge($audienceMember->toArray(), [
                'roles' => $audienceMember->roles()->map(fn(Role $role) => array_merge($role->toArray(), [
                    'group' => $role->group(), 'position' => $role->position()
                ]))
            ]));

        return $this->paginationResponse(
            $paginationItems,
            $itemCount
        );
    }

    public function user(Logic $logic)
    {
        return $this->paginate(Audience::getUsersInLogicGroup($logic));
    }

    public function group(Logic $logic)
    {
        return $this->paginate(Audience::getGroupsInLogicGroup($logic));
    }

    public function role(Logic $logic)
    {
        return $this->paginate(Audience::getRolesInLogicGroup($logic));
    }

}
