<?php

namespace App\Filters\User;

use BristolSU\Support\Filters\Contracts\Filters\UserFilter;
use FormSchema\Generator\Field;
use FormSchema\Generator\Form;
use FormSchema\Schema\Form as FormSchema;

class PredefinedFilter extends UserFilter
{

    /**
     * @inheritDoc
     */
    public function options(): FormSchema
    {
        return Form::make()->withField(
            Field::checkBox('result')->setLabel('Result')->setRequired(true)->setValue(false)
                ->setHint('Should users be allowed through?')
                ->setTooltip('If ticked, all users will pass this filter. If not ticked, no users will.')
        )->form();
    }

    /**
     * @inheritDoc
     */
    public function evaluate($settings): bool
    {
        if(array_key_exists('result', $settings)) {
            return $settings['result'];
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Allows or denies all users';
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        return 'Either let all users through, or no users through';
    }

    /**
     * @inheritDoc
     */
    public function alias()
    {
        return 'predefined_user';
    }
}
