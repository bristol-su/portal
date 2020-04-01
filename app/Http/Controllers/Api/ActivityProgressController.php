<?php


namespace App\Http\Controllers\Api;


use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;

class ActivityProgressController
{



    public function index(Activity $activity, Progress $progress)
    {
        return $progress->forActivity($activity);
    }

}
