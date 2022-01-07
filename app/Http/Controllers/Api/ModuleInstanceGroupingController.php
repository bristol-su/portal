<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;
use Illuminate\Http\Request;

class ModuleInstanceGroupingController extends Controller
{

    public function index(Activity $activity)
    {
        return ModuleInstanceGrouping::where('activity_id', $activity->id)->ordered()->get();
    }

    public function store(Request $request, Activity $activity)
    {
        $request->validate(['heading' => 'required|string|min:2|max:255']);

        return ModuleInstanceGrouping::create([
            'heading' => $request->input('heading'),
            'activity_id' => $activity->id
        ]);
    }

    public function update(Request $request, ModuleInstanceGrouping $grouping)
    {
        $request->validate(['heading' => 'required|string|min:2|max:255']);

        $grouping->heading = $request->input('heading');
        $grouping->save();

        return $grouping;
    }

    public function destroy(Request $request, ModuleInstanceGrouping $grouping)
    {
        $grouping->delete();

        return response('', 204);
    }

    public function up(Request $request, ModuleInstanceGrouping $grouping)
    {
        $grouping->moveOrderUp();

        return $grouping;
    }

    public function down(Request $request, ModuleInstanceGrouping $grouping)
    {
        $grouping->moveOrderDown();

        return $grouping;
    }

}
