<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class LinkRolesToPosition extends Formatter
{

    public function format($items)
    {
        foreach($items as $item) {
            $item->addRow('Position', $item->original()->positionId());
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
