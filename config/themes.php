<?php

return [
    'theme' => 'material',
    'tag-prefix' => 'theme',
    'components' => [
        \Twigger\Blade\Schema\Button::class,
        \Twigger\Blade\Schema\Select::class,

        \Twigger\Blade\Schema\Grid\Container::class,
        \Twigger\Blade\Schema\Grid\Row::class,
        \Twigger\Blade\Schema\Grid\Col::class
    ]
];
