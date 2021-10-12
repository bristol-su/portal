<?php


namespace App\Http\Controllers\Api\Relationships;


use App\Http\Controllers\Controller;
use BristolSU\Support\Logic\Audience\Audience;
use BristolSU\Support\Logic\Logic;

class LogicAudienceController extends Controller
{

    public function index(Logic $logic)
    {
        return collect(Audience::audience($logic));
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
