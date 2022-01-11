<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Module\Contracts\ModuleRepository;
use BristolSU\Support\Module\Module;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Http\Request;

class ModuleInstanceController extends Controller
{

    public function show(Activity $activity, ModuleInstance $moduleInstance)
    {
        if(!$activity->is($moduleInstance->activity)) {
            abort(404, 'The module instance does not belong to the activity');
        }
        return view('management.module_instances.show')
            ->with('moduleInstance', $moduleInstance->load(['actionInstances', 'completionConditionInstance', 'moduleInstanceSettings']))
            ->with('module', app(ModuleRepository::class)->findByAlias($moduleInstance->alias))
            ->with('activity', $moduleInstance->activity);
    }

    public function create(Request $request, Activity $activity, ModuleRepository $moduleRepository)
    {
        $response = view('management.module_instances.create')
            ->with('activity', $activity)
            ->with('modules', collect($moduleRepository->all())->toArray());
        if($request->has('module_type')) {
            $response->with('moduleType', $request->input('module_type'));
        }
        return $response;
    }

}
