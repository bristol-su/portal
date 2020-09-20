<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Progress\Commands\UpdateProgress;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class ActivityProgressSnapshotController extends Controller
{

    public function store(Activity $activity)
    {
        Artisan::call('progress:snapshot', [
            'activity' => $activity->id
        ]);
    }

}
