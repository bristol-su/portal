<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;

/**
 * Class GroupController
 * @package App\Http\Controllers\Api\Control
 *
 * TODO Remove this control API in favour of the actual control API
 */
class GroupController extends Controller
{

    public function show($groupId, GroupRepository $groupRepository)
    {
        return $groupRepository->getById($groupId);
    }

}
