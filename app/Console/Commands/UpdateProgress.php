<?php

namespace App\Console\Commands;

use App\Jobs\UpdateProgressInCache;
use App\Support\Progress\Progress;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UpdateProgress extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'progress:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all progress';

    /**
     * @var LogicAudience
     */
    private $logicAudience;
    /**
     * @var Progress
     */
    private $progress;

    /**
     * Create a new command instance.
     *
     * @param LogicAudience $logicAudience
     * @param Progress $progress
     */
    public function __construct(LogicAudience $logicAudience, Progress $progress)
    {
        $this->logicAudience = $logicAudience;
        $this->progress = $progress;
        parent::__construct();
    }

    public function handle()
    {
        foreach ($this->activities() as $activity) {
            $this->line(sprintf('Progress for activity #%d', $activity->id), 'bold');
            foreach ($this->audienceIdsFor($activity) as $resourceId) {
                $this->line(sprintf('Progress for resource #%d', $resourceId));
                dispatch($this->newProgressJob($activity, $resourceId));
            }
        }
    }

    /**
     * Get all activities
     *
     * @return Collection|Activity[]
     */
    private function activities(): Collection
    {
        return app(Repository::class)->active();
    }

    private function audienceIdsFor(Activity $activity)
    {
        $audience = collect();
        if ($activity->activity_for === 'user') {
            $audience = $this->logicAudience->userAudience($activity->forLogic);
        } elseif ($activity->activity_for === 'group') {
            $audience = $this->logicAudience->groupAudience($activity->forLogic);
        } elseif ($activity->activity_for === 'role') {
            $audience = $this->logicAudience->roleAudience($activity->forLogic);
        }
        return $audience->map(function ($participant) {
            return $participant->id();
        });
    }

    private function newProgressJob(Activity $activity, int $resourceId)
    {
        return new UpdateProgressInCache($activity, $resourceId, $this->progress);
    }

}
