<?php

namespace App\Console;

use App\Console\Commands\UpdateProgress;
use BristolSU\Support\Filters\Commands\CacheFilters;
use BristolSU\Support\ModuleInstance\Contracts\Scheduler\CommandStore;
use BristolSU\UnionCloud\Commands\CacheUnionCloudDataUsers;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUserGroupMemberships;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUsersUserGroupMemberships;
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
        if (app()->environment('production')) {
            $schedule->command(CacheUnionCloudDataUsers::class)->everyMinute();
            $schedule->command(CacheUnionCloudUserGroupMemberships::class)->everyMinute();
            $schedule->command(CacheUnionCloudUsersUserGroupMemberships::class)->everyMinute();
        }

        foreach (app(CommandStore::class)->all() as $alias => $commands) {
            foreach ($commands as $command => $cron) {
                $schedule->command($command)->cron($cron);
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
