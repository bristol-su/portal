<?php

namespace App\Console\Commands;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\UnionCloud\Events\UsersMembershipsRetrieved;
use BristolSU\UnionCloud\Implementations\UserGroup;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ClearUserMembershipCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-memberships:clear {userId}';

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

        $controlUserId = (int) $this->argument('userId');

        $this->line('Caching memberships for user #' . $controlUserId);

        try {
            $controlUser = app(User::class)->getById($controlUserId);
            $groups = $this->repository->getGroupsThroughUser($controlUser);
            $this->line('Found ' . count($groups) . ' groups.');
            UsersMembershipsRetrieved::dispatch($controlUser, $groups);
            cache()->forever(
                sprintf('%s@getGroupsThroughUser:%s', \BristolSU\ControlDB\Cache\Pivots\UserGroup::class, $controlUser->id()),
                $groups->map(fn(Group $group) => $group->id())->all()
            );
        } catch (\Exception $e) {
            $this->error('Failed caching memberships for user #' . $controlUserId);
            if($e instanceof ModelNotFoundException) {
                Log::info(sprintf('Members for control user %s not found', $controlUserId));
            } else {
                throw $e;
            }
        }

        return 0;
    }
}
