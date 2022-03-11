<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\ControlDB\Models\Group;

class IsGroupDisaffiliated extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        /** @var Group $group */
        $group = $formattedItem->original();
        $isDisaffiliated = $group->tags()->filter(fn($tag) => $tag->id() === (int) $this->config('disaffiliatingTagId'))->count() > 0;
        $formattedItem->addRow('Disaffiliated', $isDisaffiliated);
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::GROUPS;
    }
}
