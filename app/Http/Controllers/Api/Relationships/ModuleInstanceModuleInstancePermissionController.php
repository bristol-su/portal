<?php

namespace App\Http\Controllers\Api\Relationships;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting;
use BristolSU\Support\Permissions\Models\ModuleInstancePermission;
use Illuminate\Http\Request;

class ModuleInstanceModuleInstancePermissionController extends Controller
{

    public function index($moduleInstanceId, ModuleInstanceRepository $moduleInstanceRepository)
    {
        return $moduleInstanceRepository->getById($moduleInstanceId)->moduleInstancePermissions;
    }

    public function updateMany($moduleInstanceId, Request $request)
    {
        foreach($request->input('permissions', []) as $ability => $logicId) {
            if($logicId === null) {
                ModuleInstancePermission::where(['ability' => $ability, 'module_instance_id' => $moduleInstanceId])->delete();
            } else {
                ModuleInstancePermission::updateOrCreate(
                    ['ability' => $ability, 'module_instance_id' => $moduleInstanceId],
                    ['logic_id' => $logicId]
                );
            }
        }
    }

}
