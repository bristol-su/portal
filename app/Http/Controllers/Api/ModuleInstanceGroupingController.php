<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;
use Illuminate\Http\Request;

class ModuleInstanceGroupingController extends Controller
{

    public function index()
    {
        return ModuleInstanceGrouping::all();
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
            'order' => 'sometimes|nullable|integer|min:0|max:100',
            'heading' => 'sometimes|nullable|min:1|max:256'
        ]);

        $moduleInstanceGrouping->fill(
            $request->only(['order', 'heading'])
        );

        $moduleInstanceGrouping->save();
        return $moduleInstanceGrouping;
    }

}
