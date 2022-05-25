<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\UnionCloud\Events\UsersWithMembershipToGroupRetrieved;
use BristolSU\UnionCloud\Implementations\UserGroup;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ClearAllGroupMembershipCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group-memberships:clear-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var UserGroup
     */
    private UserGroup $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->repository = app(UserGroup::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(app(Group::class)->all() as $group) {
            cache()->forget(sprintf('%s@getUsersThroughGroup:%s', \BristolSU\ControlDB\Cache\Pivots\UserGroup::class, $group->id()));
        }

        return 0;
    }
}
