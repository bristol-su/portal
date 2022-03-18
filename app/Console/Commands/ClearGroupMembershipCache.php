<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\UnionCloud\Events\UsersWithMembershipToGroupRetrieved;
use BristolSU\UnionCloud\Implementations\UserGroup;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ClearGroupMembershipCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group-memberships:clear {groupId}';

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

        $controlGroupId = (int) $this->argument('groupId');

        $this->line('Caching memberships for group #' . $controlGroupId);

        try {
            $controlGroup = app(Group::class)->getById($controlGroupId);
            $users = $this->repository->getUsersThroughGroup($controlGroup);

            UsersWithMembershipToGroupRetrieved::dispatch($controlGroup, $users);
        } catch (\Exception $e) {
            $this->error('Failed caching memberships for group #' . $controlGroupId);
            if($e instanceof ModelNotFoundException) {
                Log::info(sprintf('Members for control group %s not found', $controlGroupId));
            } else {
                throw $e;
            }
        }

        return 0;
    }
}
