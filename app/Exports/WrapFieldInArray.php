<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use Illuminate\Support\Arr;

class WrapFieldInArray extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        foreach(Arr::wrap($this->config('field')) as $field) {
            $formattedItem->addRow(
                $field, Arr::wrap($formattedItem->getItem($field))
            );
        }
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ALL;
    }
}
