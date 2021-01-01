<?php

namespace App\Settings\Appearance;

use BristolSU\Support\Settings\Definition\Category;

class AppearanceCategory extends Category
{

    /**
     * The key of the category
     *
     * @return string
     */
    public function key(): string
    {
        return 'appearance';
    }

    /**
     * The name for the category
     *
     * @return string
     */
    public function name(): string
    {
        return 'Appearance';
    }

    /**
     * A description for the category
     *
     * @return string
     */
    public function description(): string
    {
        return 'Customise the portal to suit your brand';
    }
}
