<?php

namespace App\Console;

use App\Console\Commands\CreateMissingActivityInstancesForAllActivities;
use App\Console\Commands\RunUnionCloudCommands;
use BristolSU\Support\Filters\Commands\CacheFilters;
use BristolSU\Support\ModuleInstance\Contracts\Scheduler\CommandStore;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUserGroupMemberships;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUsersUserGroupMemberships;
use BristolSU\UnionCloud\Commands\SyncUnionCloudDataUsers;
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
            $schedule->command('progress:snapshot -E database')->dailyAt('02:00')->runInBackground();
            // $schedule->command('progress:snapshot 8 -E airtable')->weekly()->runInBackground();
            $schedule->command('progress:snapshot 9 -E airtable2022')->dailyAt('03:00')->runInBackground();

            $schedule->command(CreateMissingActivityInstancesForAllActivities::class)->daily()->runInBackground();
            $schedule->command('control:export user --exporter=bristol-control-users')->dailyAt('22:00')->runInBackground();
            $schedule->command('control:export group --exporter=bristol-control-groups')->dailyAt('22:00')->runInBackground();
            $schedule->command('control:export position --exporter=bristol-control-positions')->dailyAt('22:00')->runInBackground();
            $schedule->command('role:export')->dailyAt('00:00')->runInBackground();

            if (config('app.cache-unioncloud', false) && config('unioncloud-portal.enabled.memberships', false)) {
                $schedule->command(CacheUnionCloudUserGroupMemberships::class)->cron('*/2 * * * *');
                $schedule->command(CacheUnionCloudUsersUserGroupMemberships::class)->cron('1-59/2 * * * *');
                $schedule->command(SyncUnionCloudDataUsers::class)->dailyAt('18:00')->runInBackground();
            }

            foreach (app(CommandStore::class)->all() as $alias => $commands) {
                foreach ($commands as $command => $cron) {
                    $schedule->command($command)->cron($cron);
                }
            }
        }

        if (config('telescope.enabled', false)) {
            $schedule->command('telescope:prune --hours=168')->daily();
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
