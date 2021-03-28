<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

/**
 * @TODO Put in control
 */
class SimplePositionFormatter extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $positionData = $formattedItem->original()->data();
        $formattedItem->addRow('Position ID', $formattedItem->original()->id());
        $formattedItem->addRow('Position Name', $positionData->name());
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::POSITIONS;
    }
}
