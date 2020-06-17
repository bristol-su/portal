<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use Illuminate\Support\Arr;

class WrapFieldInArray extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $formattedItem->addRow(
            $this->config('field'), Arr::wrap($formattedItem->getItem($this->config('field'))),
        );
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ALL;
    }
}
