<?php


namespace App\Http\Controllers\Api\Relationships;


use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;

class ActivityModuleInstancesController extends Controller
{

    public function index(Activity $activity)
    {
        return $activity->moduleInstances;
    }

}
