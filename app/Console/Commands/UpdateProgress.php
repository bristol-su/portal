<?php

namespace App\Console\Commands;

use App\Jobs\UpdateActivityProgress;
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

    public function handle()
    {
        foreach ($this->activities() as $activity) {
            $this->line(sprintf('Caching progress for activity #%d', $activity->id));
            dispatch($this->newCommand($activity));
        }
        $this->info('Cached all progress');
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

    /**
     * @param $activity
     * @return UpdateActivityProgress
     */
    private function newCommand($activity)
    {
        return new UpdateActivityProgress($activity);
    }

}
