<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;
use Illuminate\Http\Request;

class ModuleInstanceGroupingOrderController extends Controller
{

    public function up(ModuleInstanceGrouping $moduleInstanceGrouping)
    {
        $moduleInstanceGrouping->moveOrderUp();

        return $moduleInstanceGrouping;
    }

    public function down(ModuleInstanceGrouping $moduleInstanceGrouping)
    {
        $moduleInstanceGrouping->moveOrderDown();

        return $moduleInstanceGrouping;
    }

}
