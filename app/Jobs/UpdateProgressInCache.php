<?php

namespace App\Jobs;

use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UpdateProgressInCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Activity
     */
    private $activity;
    /**
     * @var int
     */
    private $resourceId;
    /**
     * @var Progress
     */
    private $progress;

    /**
     * Create a new job instance.
     *
     * @param Activity $activity
     * @param int $resourceId
     */
    public function __construct(Activity $activity, int $resourceId, Progress $progress)
    {
        $this->activity = $activity;
        $this->resourceId = $resourceId;
        $this->progress = $progress;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->activityInstances() as $activityInstance) {
            $this->progress->updateProgressInCache($activityInstance);
        }
    }

    /**
     * @return Collection|ActivityInstance[]
     */
    private function activityInstances()
    {
        $activityInstances = $this->activityInstanceRepository()->allFor(
            $this->activity->id,
            $this->activity->activity_for,
            $this->resourceId
        );
        if($activityInstances->count() === 0) {
            $activityInstances->push(
                $this->createDefaultActivityInstance()
            );
        }
        return $activityInstances;
    }

    /**
     * @return ActivityInstanceRepository
     */
    private function activityInstanceRepository()
    {
        return app(ActivityInstanceRepository::class);
    }

    /**
     * @return ActivityInstance
     */
    private function createDefaultActivityInstance()
    {
        return app(DefaultActivityInstanceGenerator::class)->generate($this->activity, $this->activity->activity_for, $this->resourceId);
    }
}
