<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\GlobalSetting;
use FormSchema\Schema\Field;

class Footer extends GlobalSetting
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
                'required', 'string', 'min:2', 'max:255'
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
        return 'appearance.messaging.footer';
    }

    /**
     * The default value of the setting
     *
     * @return mixed
     */
    public function defaultValue()
    {
        return 'The Bristol SU Portal - https://github.com/bristol-su/portal';
    }

    /**
     * The field schema to show the user when editing the value
     *
     * @return Field
     */
    public function fieldOptions(): Field
    {
        return \FormSchema\Generator\Field::textInput($this->inputName())
            ->setLabel('Footer Text')
            ->setValue($this->defaultValue())
            ->setHint('The text to show in the footer')
            ->setTooltip('You can use the decimal reference to render symbols.');

    }
}
