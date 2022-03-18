<?php

namespace App\Exports;

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
        $formattedItem->addRow('President Email', $this->getEmailFromPositions($group, $this->config('president_positions')));
        $formattedItem->addRow('Treasurer Email', $this->getEmailFromPositions($group, $this->config('treasurer_positions')));
        $formattedItem->addRow('Secretary Email', $this->getEmailFromPositions($group, $this->config('secretary_positions')));
        return $formattedItem;
    }

    private function getEmailFromPositions(Group $group, array $positionIds)
    {
        $roles = $group->roles()->filter(fn(Role $role) => in_array($role->positionId(), $positionIds));
        return $roles->first()?->users()?->first()?->data()->email() ?? '';
    }

    public function handles(): string
    {
        return static::GROUPS;
    }
}
