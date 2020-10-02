<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\Definition;

class SiteTitle extends Definition
{

    public static function key(): string
    {
        return 'Appearance.Messaging.SiteTitle';
    }

    public static function defaultValue()
    {
        return 'Portal';
    }
}
