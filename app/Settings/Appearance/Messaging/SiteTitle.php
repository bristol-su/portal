<?php

namespace App\Settings\Appearance\Messaging;

use BristolSU\Support\Settings\Definition\GlobalSetting;
use FormSchema\Schema\Field;

class SiteTitle extends GlobalSetting
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
                'required', 'string', 'min:2', 'max:40'
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
        return 'appearance.messaging.site-title';
    }

    /**
     * The default value of the setting
     *
     * @return mixed
     */
    public function defaultValue()
    {
        return 'The Bristol SU Portal';
    }

    /**
     * The field schema to show the user when editing the value
     *
     * @return Field
     */
    public function fieldOptions(): Field
    {
        return \FormSchema\Generator\Field::input($this->inputName())
            ->inputType('text')
            ->label('Site Title')
            ->default($this->defaultValue())
            ->hint('The name of your site')
            ->help('This will usually be your company name, and will appear in the header and as the page title.')
            ->getSchema();

    }
}
