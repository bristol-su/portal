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
        $schedule->command(CacheFilters::class)->hourly();
        $schedule->command(UpdateProgress::class)->everyThirtyMinutes();
        $schedule->command(RunUnionCloudCommands::class)->everyMinute();
//        $schedule->command(CreateMissingActivityInstancesForAllActivities::class)->everyThirtyMinutes();
        foreach (app(CommandStore::class)->all() as $alias => $commands) {
            foreach ($commands as $command => $cron) {
                $schedule->command($command)->cron($cron);
            }
        }
        $schedule->command('control:export role --exporter=committee-contact-sheet')->everyFifteenMinutes();
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
