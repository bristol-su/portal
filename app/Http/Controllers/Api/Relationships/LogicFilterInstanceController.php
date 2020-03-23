<?php


namespace App\Http\Controllers\Api\Relationships;


use App\Http\Controllers\Controller;
use BristolSU\Support\Filters\FilterInstance;
use BristolSU\Support\Logic\Logic;
use Illuminate\Http\Request;

class LogicFilterInstanceController extends Controller
{

    public function index(Logic $logic)
    {
        return $logic->filters;
    }

    public function update(Logic $logic, FilterInstance $filterInstance, Request $request)
    {
        $filterInstance->logic_type = $request->input('logic_type');
        $filterInstance->logic_id = $logic->id;
        $filterInstance->save();
        return $filterInstance;
    }

    public function destroy(Logic $logic, FilterInstance $filterInstance)
    {
        $filterInstance->logic_id = null;
        $filterInstance->logic_type = null;
        $filterInstance->save();
        return $filterInstance;
    }

}
