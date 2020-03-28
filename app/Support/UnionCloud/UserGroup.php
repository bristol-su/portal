<?php

namespace App\Support\UnionCloud;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Twigger\UnionCloud\API\Resource\UserGroupMembership;
use Twigger\UnionCloud\API\UnionCloud;

class UserGroup implements \BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup
{

    /**
     * @var UnionCloud
     */
    private $unionCloud;
    /**
     * @var \BristolSU\ControlDB\Contracts\Repositories\User
     */
    private $userRepository;

    public function __construct(UnionCloud $unionCloud, \BristolSU\ControlDB\Contracts\Repositories\User $userRepository)
    {
        $this->unionCloud = $unionCloud;
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function getUsersThroughGroup(Group $group): Collection
    {
        return GroupGroupMembership::userGroupsForGroup($group->id())->map(function(int $userGroupId) {
            $userGroups = Cache::remember('unioncloud-user-group-get-by-id:' . $userGroupId, 100000, function() use ($userGroupId) {
                return collect($this->unionCloud->userGroupMemberships()
                    ->getByUserGroup($userGroupId, Carbon::now()->subSecond(), Carbon::now()->addSecond())
                    ->get()->toArray());
            });
            return $userGroups->map(function(UserGroupMembership $ugm) {
                    try {
                        return $this->userRepository->getByDataProviderId(DataUserModel::fromUnionCloudUser($ugm->user)->id());
                    } catch (ModelNotFoundException $e) {
                        return $this->userRepository->create(DataUserModel::fromUnionCloudUser($ugm->user)->id());
                    }
            });
        })->flatten(1);
    }

    /**
     * @inheritDoc
     */
    public function getGroupsThroughUser(User $user): Collection
    {
        return collect();
    }

    /**
     * @inheritDoc
     */
    public function addUserToGroup(User $user, Group $group): void
    {
        throw new \Exception('Cannot add user to unioncloud group');
    }

    /**
     * @inheritDoc
     */
    public function removeUserFromGroup(User $user, Group $group): void
    {
        throw new \Exception('Cannot remove user to unioncloud group');
    }
}
