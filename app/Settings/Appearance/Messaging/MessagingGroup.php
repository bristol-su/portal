<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\Group;

class MessagingGroup extends Group
{

    /**
     * The key of the group
     *
     * @return string
     */
    public function key(): string
    {
        return 'appearance.messaging';
    }

    /**
     * The name for the group
     *
     * @return string
     */
    public function name(): string
    {
        return 'Messaging';
    }

    /**
     * A description for the group
     *
     * @return string
     */
    public function description(): string
    {
        return 'Set the messaging to show users';
    }
}
