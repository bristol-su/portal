<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;
use Illuminate\Http\Request;

class ModuleInstanceGroupingController extends Controller
{

    public function index()
    {
        return ModuleInstanceGrouping::ordered()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|min:1|max:256'
        ]);

        return ModuleInstanceGrouping::create([
            'heading' => $request->input('heading')
        ]);
    }

    public function update(ModuleInstanceGrouping $moduleInstanceGrouping, Request $request)
    {
        $request->validate([
            'heading' => 'sometimes|nullable|min:1|max:256'
        ]);

        $moduleInstanceGrouping->fill(
            $request->only(['heading'])
        );

        $moduleInstanceGrouping->save();
        return $moduleInstanceGrouping;
    }

}
