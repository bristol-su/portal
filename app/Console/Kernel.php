<?php

namespace App\Console;

use App\Console\Commands\CreateMissingActivityInstancesForAllActivities;
use App\Console\Commands\RunUnionCloudCommands;
use App\Console\Commands\UpdateProgress;
use BristolSU\Support\Filters\Commands\CacheFilters;
use BristolSU\Support\ModuleInstance\Contracts\Scheduler\CommandStore;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if(app()->environment('production')) {
            $schedule->command(CacheFilters::class)->hourly()->runInBackground()->when(function() {
                return config('support.caching.filters.enabled');
            });
            $schedule->command('progress:snapshot -E database')->hourly()->runInBackground();
            $schedule->command('progress:snapshot -E portal-airtable')->hourly()->runInBackground();
            $schedule->command(RunUnionCloudCommands::class)->everyMinute()->runInBackground();
            $schedule->command(CreateMissingActivityInstancesForAllActivities::class)->daily()->runInBackground();
            $schedule->command('control:export role --exporter=committee-contact-sheet')->everyThirtyMinutes()->runInBackground();
            $schedule->command('control:export role --exporter=committee-contact-sheet-old')->daily()->runInBackground();
            $schedule->command('control:export role --exporter=portal-airtable')->daily()->runInBackground();

            foreach (app(CommandStore::class)->all() as $alias => $commands) {
                foreach ($commands as $command => $cron) {
                    $schedule->command($command)->cron($cron);
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
