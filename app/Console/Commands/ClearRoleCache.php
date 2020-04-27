<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository;

class ClearRoleCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rolecache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear role cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Repository $cache, Role $roleRepository)
    {
        $cache->forget(RoleRoleTag::class . '@getRolesThroughTag:12');
        $cache->forget(RoleRoleTag::class . '@getRolesThroughTag:13');
        foreach(app(Role::class)->all() as $role) {
            $cache->forget(RoleRoleTag::class . '@getTagsThroughRole:' . $role->id());
        }
    }
}
