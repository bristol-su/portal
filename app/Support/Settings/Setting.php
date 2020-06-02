<?php

namespace App\Support\Settings;

class Setting implements SettingRepository
{

    /**
     * @inheritDoc
     */
    public function has($key): bool
    {
        return SettingModel::key($key)->count() === 1;
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        if($this->has($key)) {
            return SettingModel::key($key)->firstOrFail()->getSettingValue();
        }
        return $default;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        $settings = [];
        SettingModel::all()->each(function(SettingModel $setting) use (&$settings) {
            $settings[$setting->getSettingKey()] = $setting->getSettingValue();
        });
        return $settings;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value = null): void
    {
        SettingModel::updateOrCreate(['key' => $key], [
            'key' => $key,
            'value' => $value
        ]);
    }
}
