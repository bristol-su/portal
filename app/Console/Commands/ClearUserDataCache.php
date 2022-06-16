<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\User;
use Illuminate\Console\Command;

class ClearUserDataCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:clear {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controlUserId = (int) $this->argument('userId');

        $this->line('Caching user info for user #' . $controlUserId);

        $controlUser = app(User::class)->getById($controlUserId);
        $key = sprintf('%s@getGroupsThroughUser:%s', \BristolSU\ControlDB\Cache\Pivots\UserGroup::class, $controlUser->id());
        cache()->forget($key);

        return 0;
    }
}
