<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\Definition;

class Footer extends Definition
{

    public static function key(): string
    {
        return 'Appearance.Messaging.Footer';
    }

    public static function defaultValue()
    {
        return '';
    }
}
