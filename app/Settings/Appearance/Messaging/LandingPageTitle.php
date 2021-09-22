<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\GlobalSetting;
use FormSchema\Schema\Field;

class LandingPageTitle extends GlobalSetting
{

    /**
     * Return the validation rules for the setting.
     *
     * You may also override the validator method to customise the validator further
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            $this->inputName() => [
                'required', 'string', 'min:2', 'max:10000'
            ]
        ];
    }

    /**
     * The key for the setting
     *
     * @return string
     */
    public function key(): string
    {
        return 'appearance.messaging.landing.title';
    }

    /**
     * The default value of the setting
     *
     * @return mixed
     */
    public function defaultValue()
    {
        return 'Welcome to the Bristol SU Portal';
    }

    /**
     * The field schema to show the user when editing the value
     *
     * @return Field
     */
    public function fieldOptions(): Field
    {
        return \FormSchema\Generator\Field::textInput($this->inputName())
            ->setLabel('Landing Page Title')
            ->setValue($this->defaultValue())
            ->setHint('The title of the landing page')
            ->setTooltip('This will be shown on the landing page of the portal, and should explain what the portal is.');

    }
}
