<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\Progress\Handlers\Database\Models\Progress;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityProgressController extends Controller
{

    public function index(Activity $activity, Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'incomplete' => 'sometimes|array',
            'incomplete.*' => 'string|exists:module_instances,id',
            'complete' => 'sometimes|array',
            'complete.*' => 'string|exists:module_instances,id',
            'hidden' => 'sometimes|array',
            'hidden.*' => 'string|exists:module_instances,id',
            'visible' => 'sometimes|array',
            'visible.*' => 'string|exists:module_instances,id',
            'active' => 'sometimes|array',
            'active.*' => 'string|exists:module_instances,id',
            'inactive' => 'sometimes|array',
            'inactive.*' => 'string|exists:module_instances,id',
            'mandatory' => 'sometimes|array',
            'mandatory.*' => 'string|exists:module_instances,id',
            'optional' => 'sometimes|array',
            'optional.*' => 'string|exists:module_instances,id',
            'progress_above' => 'sometimes|numeric|min:0|max:100|empty_if:progress_below',
            'progress_below' => 'sometimes|numeric|min:0|max:100|empty_if:progress_above',
            'sort_by' => 'sometimes|string',
            'sort_desc' => 'sometimes|boolean',
            'per_page' => 'sometimes|numeric|min:1|max:200'
        ]);

        $appendQuery = $request->query->all();
        if(array_key_exists('page', $appendQuery)) {
            unset($appendQuery['page']);
        }

        return (Progress
            ::with('moduleInstanceProgress')
            ->whereHas('moduleInstanceProgress', function(Builder $query) use ($request) {
                if($request->has('incomplete')) {
                    $query->where('complete', false)
                        ->whereIn('module_instance_id', $request->input('incomplete'));
                }
                if($request->has('complete')) {
                    $query->where('complete', true)
                        ->whereIn('module_instance_id', $request->input('complete'));
                }
                if($request->has('hidden')) {
                    $query->where('visible', false)
                        ->whereIn('module_instance_id', $request->input('hidden'));
                }
                if($request->has('visible')) {
                    $query->where('visible', true)
                        ->whereIn('module_instance_id', $request->input('visible'));
                }
                if($request->has('active')) {
                    $query->where('active', true)
                        ->whereIn('module_instance_id', $request->input('active'));
                }
                if($request->has('inactive')) {
                    $query->where('active', false)
                        ->whereIn('module_instance_id', $request->input('inactive'));
                }
                if($request->has('mandatory')) {
                    $query->where('mandatory', true)
                        ->whereIn('module_instance_id', $request->input('mandatory'));
                }
                if($request->has('optional')) {
                    $query->where('mandatory', false)
                        ->whereIn('module_instance_id', $request->input('optional'));
                }
            })
            ->when($request->has('progress_above'), function(Builder $query) use ($request) {
                $query->where('percentage', '>=', $request->input('progress_above'));
            })
            ->when($request->has('progress_below'), function(Builder $query) use ($request) {
                $query->where('percentage', '<=', $request->input('progress_below'));
            })
            ->when($request->has('sort_by'), function(Builder $query) use ($request) {
                $query->orderBy('sort_by', ($request->input('sort_desc', false) ? 'DESC' : 'ASC'));
            })
            ->paginate($request->input('per_page', 10)))
            ->appends($appendQuery);

    }
}
