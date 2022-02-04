<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Module\Contracts\ModuleRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;

class ActionController extends Controller
{

    public function show(ActionInstance $actionInstance)
    {
        return view('management.actions.show')
            ->with('action', $actionInstance)
            ->with('moduleInstance', $actionInstance->moduleInstance)
            ->with('module', app(ModuleRepository::class)->findByAlias($actionInstance->moduleInstance->alias));
    }

    public function create(Activity $activity, ModuleInstance $moduleInstance)
    {
        return view('management.actions.create')
            ->with('moduleInstance', $moduleInstance)
            ->with('module', app(ModuleRepository::class)->findByAlias($moduleInstance->alias));
    }

}
