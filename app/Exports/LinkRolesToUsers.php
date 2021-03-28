<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class LinkRolesToUsers extends Formatter
{

    public function format($items)
    {
        foreach($items as $item) {
            $ids = [];
            foreach($item->original()->users() as $user) {
                $ids[] = $user->id();
            }
            $item->addRow('Users', $ids);
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
