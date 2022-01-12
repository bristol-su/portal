<?php

namespace App\Http\Controllers\Api\Relationships;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\Connection\ModuleInstanceService;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;
use BristolSU\Support\Permissions\Models\ModuleInstancePermission;
use Illuminate\Http\Request;

class ModuleInstanceModuleInstanceServiceController extends Controller
{

    public function index($moduleInstanceId, ModuleInstanceRepository $moduleInstanceRepository)
    {
        return $moduleInstanceRepository->getById($moduleInstanceId)->moduleInstanceServices;
    }

    public function updateMany($moduleInstanceId, Request $request)
    {
        foreach($request->input('services', []) as $service => $connectionId) {
            if($connectionId === null) {
                ModuleInstanceService::where(['service' => $service, 'module_instance_id' => $moduleInstanceId])->delete();
            } else {
                ModuleInstanceService::updateOrCreate(
                    ['service' => $service, 'module_instance_id' => $moduleInstanceId],
                    ['connection_id' => $connectionId]
                );
            }
        }
    }

}
