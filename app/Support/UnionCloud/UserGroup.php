<?php

namespace App\Support\UnionCloud;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
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
    /**
     * @var \BristolSU\ControlDB\Contracts\Repositories\Group
     */
    private $groupRepository;

    public function __construct(UnionCloud $unionCloud, \BristolSU\ControlDB\Contracts\Repositories\User $userRepository, \BristolSU\ControlDB\Contracts\Repositories\Group $groupRepository)
    {
        $this->unionCloud = $unionCloud;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
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
        try {
            $ugmIds = collect($this->unionCloud->userGroupMemberships()->getByUser($user->dataProviderId())->get()->toArray())
                ->map(function(UserGroupMembership $ugm) {
                    return $ugm->usergroup->ug_id;
                });
        } catch (ResourceNotFoundException $e) {
            throw new ModelNotFoundException;
        }


        return $ugmIds->map(function(int $ugmId) {
            return GroupGroupMembership::groupsFromUserGroup($ugmId)->map(function(int $groupId) {
                return $this->groupRepository->getById($groupId);
            })->flatten(1);
        })->flatten(1);
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
