<?php

namespace App\Console\Commands;

use BristolSU\Support\Activity\Activity;
use Illuminate\Console\Command;

class RestoreActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:restore {activity : The ID of the activity to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the given activity by ID';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activity = Activity::onlyTrashed()->findOrFail($this->argument('activity'));
        $activity->restore();
        $this->output->success('Activity restored');
        return 0;
    }
}
