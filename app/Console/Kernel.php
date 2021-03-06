<?php

namespace App\Console;

use App\Console\Commands\CreateMissingActivityInstancesForAllActivities;
use App\Console\Commands\RunUnionCloudCommands;
use BristolSU\Support\Filters\Commands\CacheFilters;
use BristolSU\Support\ModuleInstance\Contracts\Scheduler\CommandStore;
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
        if(app()->environment('production')) {
            $schedule->command(CacheFilters::class)->twiceDaily()->runInBackground()->when(function() {
                return config('support.caching.filters.enabled');
            });
            $schedule->command('progress:snapshot -E database')->dailyAt('07:00')->runInBackground();
            $schedule->command('progress:snapshot 1 -E portal-airtable')->dailyAt('06:00')->runInBackground();

            $schedule->command(CreateMissingActivityInstancesForAllActivities::class)->daily()->runInBackground();
            $schedule->command('control:export role --exporter=committee-contact-sheet')->cron('0 */2 * * *')->runInBackground();
            $schedule->command('control:export role --exporter=committee-contact-sheet-old')->daily()->runInBackground();
            $schedule->command('control:export role --exporter=portal-airtable')->dailyAt('22:00')->runInBackground();

            if(config('app.cache-unioncloud', false) && config('unioncloud-portal.enabled.memberships', false)) {
                $schedule->command(CacheUnionCloudUserGroupMemberships::class)->cron('*/2 * * * *');
                $schedule->command(CacheUnionCloudUsersUserGroupMemberships::class)->cron('1-59/2 * * * *');
            }

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
