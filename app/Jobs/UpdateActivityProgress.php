<?php

namespace App\Jobs;

use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\ActivityInstance;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use Clockwork\Request\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UpdateActivityProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Activity
     */
    private $activity;

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
     * @param LogicAudience $logicAudience
     * @return void
     */
    public function handle(LogicAudience $logicAudience)
    {
        foreach ($this->audienceIdsFor($this->activity, $logicAudience) as $resourceId) {
            dispatch($this->newProgressJob($this->activity, $resourceId));
        }
    }

    private function audienceIdsFor(Activity $activity, LogicAudience $logicAudience)
    {
        $audience = collect();
        if ($activity->activity_for === 'user') {
            $audience = $logicAudience->userAudience($activity->forLogic);
        } elseif ($activity->activity_for === 'group') {
            $audience = $logicAudience->groupAudience($activity->forLogic);
        } elseif ($activity->activity_for === 'role') {
            $audience = $logicAudience->roleAudience($activity->forLogic);
        }
        return $audience->map(function ($participant) {
            return $participant->id();
        });
    }

    private function newProgressJob(Activity $activity, int $resourceId)
    {
        return new UpdateProgressInCache($activity, $resourceId);
    }
}
