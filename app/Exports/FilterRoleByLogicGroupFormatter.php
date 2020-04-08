<?php

namespace App\Exports;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\Support\Logic\Contracts\LogicRepository;
use BristolSU\Support\Logic\Facade\LogicTester;

class FilterRoleByLogicGroupFormatter extends Formatter
{

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function format($items)
    {
        if($this->config('logicId')) {
            $logicGroup = app(LogicRepository::class)->getById((int) $this->config('logicId'));
            return array_filter($items, function($item) use ($logicGroup) {
                return LogicTester::evaluate($logicGroup, null, null, $item);
            });
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
