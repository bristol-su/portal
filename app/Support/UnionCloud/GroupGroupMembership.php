<?php

namespace App\Support\UnionCloud;

use Illuminate\Database\Eloquent\Model;

class GroupGroupMembership extends Model
{

    protected $table = 'unioncloud_groups_membership_usergroups';

    public static function userGroupsForGroup(int $groupId)
    {
        return static::query()->where('group_id', $groupId)->get()->pluck('usergroup_id');
    }

}
