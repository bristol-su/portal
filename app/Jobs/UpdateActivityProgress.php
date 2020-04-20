<?php

namespace App\Jobs;

use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateActivityProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Activity
     */
    private $activity;

    private $childJobDelay = 0;

    /**
     * Create a new job instance.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Execute the job.
     *
     * @param ActivityInstanceRepository $activityInstanceRepository
     * @return void
     */
    public function handle(ActivityInstanceRepository $activityInstanceRepository)
    {
        foreach ($this->audienceIdsFor($this->activity, $activityInstanceRepository) as $resourceId) {
            dispatch($this->newProgressJob($this->activity, $resourceId));
        }
    }

    private function audienceIdsFor(Activity $activity, ActivityInstanceRepository $activityInstanceRepository)
    {
        return $activityInstanceRepository->allForActivity($activity->id)->unique('resource_id')->pluck('resource_id');
    }

    private function newProgressJob(Activity $activity, int $resourceId)
    {
        $delay = $this->childJobDelay;
        $this->childJobDelay += 10;
        return (new UpdateProgressInCache($activity, $resourceId))->delay($delay);
    }
}
