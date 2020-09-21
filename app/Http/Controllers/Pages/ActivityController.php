<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;

class ActivityController extends Controller
{

    public function participant(Activity $activity)
    {
        return view('pages.portal.activity')->with([
            'activity' => $activity,
            'admin' => false,
            'drawerTag' => 'p-nav-drawer-activity'
        ]);
    }

    public function administrator(Activity $activity)
    {
        return view('pages.portal.activity')->with([
            'activity' => $activity,
            'admin' => true,
            'drawerTag' => 'p-nav-drawer-activity'
        ]);
    }

}

