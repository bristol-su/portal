<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class LinkRolesToGroup extends Formatter
{

    public function format($items)
    {
        foreach($items as $item) {
            $item->addRow('Group', $item->original()->groupId());
        }
        return $items;
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}
