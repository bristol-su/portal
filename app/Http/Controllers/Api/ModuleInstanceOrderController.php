<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Http\Request;

class ModuleInstanceOrderController extends Controller
{

    public function up(ModuleInstance $moduleInstance)
    {
        $moduleInstance->moveOrderUp();

        return $moduleInstance;
    }

    public function down(ModuleInstance $moduleInstance)
    {
        $moduleInstance->moveOrderDown();

        return $moduleInstance;
    }

}
