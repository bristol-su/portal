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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Spatie\RateLimitedMiddleware\RateLimited;

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
     * Create a new job instance.
     *
     * @param Activity $activity
     * @param int $resourceId
     */
    public function __construct(Activity $activity, int $resourceId)
    {
        $this->activity = $activity;
        $this->resourceId = $resourceId;
    }

    public function middleware()
    {
        $rateLimitedMiddleware = (new RateLimited())
            ->allow(5)
            ->everySeconds(60)
            ->releaseAfterSeconds(90);

        return [$rateLimitedMiddleware];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Progress $progress)
    {
        foreach($this->activityInstances() as $activityInstance) {
            $progress->updateProgressInCache($activityInstance);
        }
        Log::info('Progress');
    }

    /**
     * @return Collection|ActivityInstance[]
     */
    private function activityInstances()
    {
        return $this->activityInstanceRepository()->allFor(
            $this->activity->id,
            $this->activity->activity_for,
            $this->resourceId
        );
    }

    /**
     * @return ActivityInstanceRepository
     */
    private function activityInstanceRepository()
    {
        return app(ActivityInstanceRepository::class);
    }
}
