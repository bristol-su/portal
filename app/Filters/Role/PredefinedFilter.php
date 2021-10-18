<?php

namespace App\Filters\Role;

use BristolSU\Support\Filters\Contracts\Filters\RoleFilter;
use FormSchema\Generator\Field;
use FormSchema\Generator\Form;
use FormSchema\Schema\Form as FormSchema;

class PredefinedFilter extends RoleFilter
{

    /**
     * @inheritDoc
     */
    public function options(): FormSchema
    {
        return Form::make()->withField(
            Field::checkBox('result')->setLabel('Result')->setRequired(true)->setValue(false)
                ->setHint('Should roles be allowed through?')
                ->setTooltip('If ticked, all roles will pass this filter. If not ticked, no roles will.')
        )->getSchema();
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
        return 'Allows or denies all roles';
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        return 'Either let all roles through, or no roles through';
    }

    /**
     * @inheritDoc
     */
    public function alias()
    {
        return 'predefined_role';
    }
}
