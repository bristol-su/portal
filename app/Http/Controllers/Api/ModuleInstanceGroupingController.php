<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;

class ModuleInstanceGroupingController extends Controller
{

    public function index()
    {
        return ModuleInstanceGrouping::all();
    }

}
