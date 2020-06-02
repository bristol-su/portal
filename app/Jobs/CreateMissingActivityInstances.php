<?php

namespace App\Jobs;

use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateMissingActivityInstances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Activity
     */
    private $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LogicAudience $logicAudience, DefaultActivityInstanceGenerator $generator)
    {
        foreach($this->audience($logicAudience) as $audience) {
            $generator->generate($this->activity, $this->activity->activity_for, $audience->id());
        }
    }

    private function audience(LogicAudience $logicAudience)
    {
        if ($this->activity->activity_for === 'user') {
            return $logicAudience->userAudience($this->activity->forLogic);
        } elseif ($this->activity->activity_for === 'group') {
            return $logicAudience->groupAudience($this->activity->forLogic);
        } elseif ($this->activity->activity_for === 'role') {
            return $logicAudience->roleAudience($this->activity->forLogic);
        }
    }

}
