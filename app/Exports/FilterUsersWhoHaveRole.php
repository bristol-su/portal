<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use BristolSU\Support\Logic\Facade\LogicTester;

/**
 * @TODO Put in control
 */
class FilterUsersWhoHaveRole extends Formatter
{

    public function format($items)
    {
        return array_filter($items, function($item) {
            return $item->original()->roles()->count() > 0;
        });
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::USERS;
    }
}
