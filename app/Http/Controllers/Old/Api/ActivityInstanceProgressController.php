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

class ActivityInstanceProgressController extends Controller
{

    public function index(ActivityInstance $activityInstance, Request $request, ProgressRepository $progressRepository)
    {
        return $progressRepository->allForActivityInstance($activityInstance->id)->reverse()->values();
    }

}
