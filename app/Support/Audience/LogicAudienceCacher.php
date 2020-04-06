<?php

namespace App\Support\Audience;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\Support\Logic\Audience\AudienceMember;
use BristolSU\Support\Logic\Contracts\Audience\AudienceMemberFactory;
use BristolSU\Support\Logic\Contracts\Audience\LogicAudience;
use BristolSU\Support\Logic\Logic;
use Illuminate\Cache\Repository;

class LogicAudienceCacher extends LogicAudience
{

    /**
     * @var Repository
     */
    private $cache;

    public static $cacheFor = 604800;
    /**
     * @var LogicAudience
     */
    private $logicAudience;

    public function __construct(LogicAudience $logicAudience, Repository $cache)
    {
        $this->cache = $cache;
        $this->logicAudience = $logicAudience;
    }

    public function groupAudience(Logic $logic)
    {
        if($this->cache->has($this->getKey('group', $logic))) {
            $groupRepository = app(Group::class);
            return collect($this->cache->get($this->getKey('group', $logic)))->map(function($groupId) use ($groupRepository) {
                return $groupRepository->getById($groupId);
            });
        }
        $audience = $this->logicAudience->groupAudience($logic);

        $this->cache->put($this->getKey('group', $logic), static::$cacheFor, $audience->map(function(\BristolSU\ControlDB\Contracts\Models\Group $group) {
            return $group->id();
        })->toArray());

        return $audience;
    }

    public function roleAudience(Logic $logic)
    {
        if($this->cache->has($this->getKey('role', $logic))) {
            $roleRepository = app(Role::class);
            return collect($this->cache->get($this->getKey('role', $logic)))->map(function($roleId) use ($roleRepository) {
                return $roleRepository->getById($roleId);
            });
        }
        $audience = $this->logicAudience->roleAudience($logic);

        $this->cache->put($this->getKey('role', $logic), static::$cacheFor, $audience->map(function(\BristolSU\ControlDB\Contracts\Models\Role $role) {
            return $role->id();
        })->toArray());

        return $audience;
    }

    public function userAudience(Logic $logic)
    {
        if($this->cache->has($this->getKey('user', $logic))) {
            $userRepository = app(User::class);
            return collect($this->cache->get($this->getKey('user', $logic)))->map(function($userId) use ($userRepository) {
                return $userRepository->getById($userId);
            });
        }
        $audience = $this->logicAudience->userAudience($logic);

        $this->cache->put($this->getKey('user', $logic), static::$cacheFor, $audience->map(function(\BristolSU\ControlDB\Contracts\Models\User $user) {
            return $user->id();
        })->toArray());

        return $audience;
    }

    /**
     * @inheritDoc
     */
    public function audience(Logic $logic)
    {
        if($this->cache->has($this->getKey('audience', $logic))) {
            $userRepository = app(User::class);
            $audienceMemberFactory = app(AudienceMemberFactory::class);
            return collect($this->cache->get($this->getKey('audience', $logic)))->map(function($userId) use ($audienceMemberFactory, $userRepository) {
                return $audienceMemberFactory->fromUser($userRepository->getById($userId));
            });
        }
        $audience = $this->logicAudience->userAudience($logic);

        $this->cache->put($this->getKey('audience', $logic), static::$cacheFor, $audience->map(function(AudienceMember $audienceMember) {
            return $audienceMember->user()->id();
        })->toArray());

        return $audience;
    }

    private function getKey(string $type, Logic $logic)
    {
        return static::class . ':' . $type . ':' . $logic->id;
    }
}
