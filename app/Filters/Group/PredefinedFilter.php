<?php

namespace App\Filters\Group;

use BristolSU\Support\Filters\Contracts\Filters\GroupFilter;
use FormSchema\Generator\Field;
use FormSchema\Generator\Form;
use FormSchema\Schema\Form as FormSchema;

class PredefinedFilter extends GroupFilter
{

    /**
     * @inheritDoc
     */
    public function options(): FormSchema
    {
        return Form::make()->withField(
            Field::checkBox('result')->label('Result')->required(true)->default(false)
                ->hint('Should groups be allowed through?')
                ->help('If ticked, all groups will pass this filter. If not ticked, no groups will.')
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
        return 'Allows or denies all groups';
    }

    /**
     * @inheritDoc
     */
    public function description()
    {
        return 'Either let all groups through, or no groups through';
    }

    /**
     * @inheritDoc
     */
    public function alias()
    {
        return 'predefined_group';
    }
}
