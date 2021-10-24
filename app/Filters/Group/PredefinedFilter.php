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
            Field::checkBox('result')->setLabel('Result')->setRequired(true)->setValue(false)
                ->setHint('Should groups be allowed through?')
                ->setTooltip('If ticked, all groups will pass this filter. If not ticked, no groups will.')
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

    /**
     * This filter doesn't listen to anything, since it doesn't depend on any data.
     *
     * @return array
     */
    public static function clearOn(): array
    {
        return [];
    }
}
