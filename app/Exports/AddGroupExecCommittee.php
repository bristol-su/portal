<?php

namespace App\Exports;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;

class AddGroupExecCommittee extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        /** @var Group $group */
        $group = $formattedItem->original();
        $formattedItem->addRow('President Email 2021', $this->getEmailFromPositions($group, $this->config('president_positions'), 'committee_year.y2021'));
        $formattedItem->addRow('Treasurer Email 2021', $this->getEmailFromPositions($group, $this->config('treasurer_positions'), 'committee_year.y2021'));
        $formattedItem->addRow('Secretary Email 2021', $this->getEmailFromPositions($group, $this->config('secretary_positions'), 'committee_year.y2021'));
        $formattedItem->addRow('President Email 2022', $this->getEmailFromPositions($group, $this->config('president_positions'), 'committee_year.y2022'));
        $formattedItem->addRow('Treasurer Email 2022', $this->getEmailFromPositions($group, $this->config('treasurer_positions'), 'committee_year.y2022'));
        $formattedItem->addRow('Secretary Email 2022', $this->getEmailFromPositions($group, $this->config('secretary_positions'), 'committee_year.y2022'));
        return $formattedItem;
    }

    private function getEmailFromPositions(Group $group, array $positionIds, string $roleTagReference)
    {
        $roles = $group->roles()
            ->filter(fn(Role $role) => in_array($role->positionId(), $positionIds))
            ->filter(fn(Role $role) => $role->tags()->filter(fn(RoleTag $roleTag) => $roleTag->fullReference() === $roleTagReference)->count() > 0);
        return $roles->first()?->users()?->first()?->data()->email() ?? '';
    }

    public function handles(): string
    {
        return static::GROUPS;
    }
}
