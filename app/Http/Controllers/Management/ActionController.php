<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ModuleInstance\ModuleInstance;

class ActionController extends Controller
{

    public function show(ActionInstance $actionInstance)
    {
        return view('management.actions.show')->with('action', $actionInstance);
    }

    public function create(Activity $activity, ModuleInstance $moduleInstance)
    {
        return view('management.actions.create')->with('moduleInstance', $moduleInstance);
    }

}
