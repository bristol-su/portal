<?php

namespace App\Support\Settings;

interface SettingRepository
{

    /**
     * Determine if the given setting exists.
     *
     * @param string $key Setting key
     * @return bool If the setting exists
     */
    public function has($key): bool;

    /**
     * Get the specified setting.
     *
     * @param array|string $key Key of the setting
     * @param mixed $default Default value if the setting does not exist
     * @return mixed Value of the setting, or the default value
     */
    public function get($key, $default = null);

    /**
     * Get all of the settings for the application.
     *
     * @return array A collection of setting values, with the key as the setting key
     */
    public function all(): array;

    /**
     * Set a given setting.
     *
     * @param array|string $key Key of the settings
     * @param mixed $value Value to set
     * @return void
     */
    public function set($key, $value = null): void;

}
