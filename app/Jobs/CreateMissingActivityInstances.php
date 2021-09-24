<?php

namespace App\Jobs;

use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\DefaultActivityInstanceGenerator;
use BristolSU\Support\Logic\Audience\Audience;
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
    public function handle(DefaultActivityInstanceGenerator $generator)
    {
        foreach($this->audience() as $audience) {
            $generator->generate($this->activity, $this->activity->activity_for, $audience->id());
        }
    }

    private function audience()
    {
        if ($this->activity->activity_for === 'user') {
            return Audience::getUsersInLogicGroup($this->activity->forLogic);
        } elseif ($this->activity->activity_for === 'group') {
            return Audience::getGroupsInLogicGroup($this->activity->forLogic);
        } elseif ($this->activity->activity_for === 'role') {
            return Audience::getRolesInLogicGroup($this->activity->forLogic);
        }
    }

}
