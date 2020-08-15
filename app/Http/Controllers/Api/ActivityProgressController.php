<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use BristolSU\Module\DataEntry\Models\ActivityInstance;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\Progress\Handlers\Database\Models\Progress;
use BristolSU\Support\Progress\Handlers\Database\ProgressRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ActivityProgressController extends Controller
{

    public function index(Activity $activity, Request $request, ProgressRepository $progressRepository)
    {
        $request->validate([
            'activity_instances' => 'sometimes|array',
            'activity_instances.*' => 'sometimes|exists:activity_instances,id',
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
            'progress_above' => 'sometimes|numeric|min:0|max:100',
            'progress_below' => 'sometimes|numeric|min:0|max:100',
            'sort_by' => 'sometimes|string|in:percentage,name',
            'sort_desc' => 'sometimes|boolean',
            'per_page' => 'sometimes|numeric|min:1|max:200',
            'page' => 'sometimes|numeric|min:1'
        ]);

        $sortByName = false;

        $activityInstances = ActivityInstance
            ::where('activity_id', $activity->id)
            // Filter to only given activity instances to allow searching
            ->when($request->has('activity_instances'), function(Builder $query) use ($request) {
                $query->whereIn('id', $request->input('activity_instances'));
            })
            ->get();

        if($request->input('sort_by', 'percentage') === 'name') {
            $sortByName = true;
        }

        $progress = $progressRepository->searchRecent(
            $activityInstances->pluck('id')->toArray(),
            ( $sortByName ? 'percentage' : $request->input('sort_by', 'percentage') ),
            $request->input('sort_desc', true),
            $request->input('incomplete', []),
            $request->input('complete', []),
            $request->input('hidden', []),
            $request->input('visible', []),
            $request->input('active', []),
            $request->input('inactive', []),
            $request->input('mandatory', []),
            $request->input('optional', []),
            $request->input('progress_above', 0.00),
            $request->input('progress_below', 100.00),
        );

        if($sortByName) {
            $sortedActivityInstances = $activityInstances->sortBy(function($activityInstance) {
                return $activityInstance->participant_name;
            })->pluck('id')->toArray();
            $progress = $progress->sortBy(function($p) use ($sortedActivityInstances) {
                return array_search($p->activity_instance_id, $sortedActivityInstances);
            })->values();
            if($request->input('sort_desc', false)) {
                $progress = $progress->reverse()->values();
            }
        }

        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $appendQuery = $request->query->all();
        if(array_key_exists('page', $appendQuery)) {
            unset($appendQuery['page']);
        }

        return (new LengthAwarePaginator(
            $progress->forPage($page, $perPage)->values(),
            $progress->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page'
            ]
        ))->appends($appendQuery);

    }

}
