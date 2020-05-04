<?php


namespace App\Http\Controllers\Api;


use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityProgressController
{

    public function index(Activity $activity, Progress $progress, Request $request, ActivityInstanceRepository $activityInstanceRepository)
    {
        $count = $activityInstanceRepository->allForActivity($activity->id)->count();
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);
        return new LengthAwarePaginator(
            $progress->paginateActivity($activity, $page, $perPage),
            $count,
            $perPage,
            $page
        );
    }

}
