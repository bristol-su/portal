<?php

namespace App\Console\Commands;

use BristolSU\UnionCloud\Commands\CacheUnionCloudDataUsers;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUserGroupMemberships;
use BristolSU\UnionCloud\Commands\CacheUnionCloudUsersUserGroupMemberships;
use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Log;

class RunUnionCloudCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unioncloud:scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled unioncloud commands';
    /**
     * @var Repository
     */
    private $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->config->get('app.cache-unioncloud', false)) {
            if ($this->config->get('unioncloud-portal.enabled.data-users')) {
                try {
                    $this->call(CacheUnionCloudDataUsers::class);
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
            if ($this->config->get('unioncloud-portal.enabled.memberships')) {
                $this->line('Caching memberships');
                try {
                    $this->call(CacheUnionCloudUserGroupMemberships::class);
                } catch (\Exception $e) {
                    Log::error($e);
                }
                try {
                    $this->call(CacheUnionCloudUsersUserGroupMemberships::class);
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
        }
    }
}
