<?php

namespace App\Http\Controllers\Api\Relationships;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;

class ModuleInstanceModuleInstancePermissionController extends Controller
{

    public function index($moduleInstanceId, ModuleInstanceRepository $moduleInstanceRepository)
    {
        return $moduleInstanceRepository->getById($moduleInstanceId)->moduleInstancePermissions;
    }

}
