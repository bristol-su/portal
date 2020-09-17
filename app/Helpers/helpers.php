<?php

if (!function_exists('siteSetting')) {
    /**
     * Retrieve the value of a site setting
     *
     * @param string $key Key of the setting to retrieve
     * @param mixed $default Default to return if the setting is not found
     * @return mixed Value of the setting
     */
    function siteSetting(string $key, $default = null)
    {
        return app(\App\Support\Settings\SettingRepository::class)->get($key, $default);
    }
}

if (!function_exists('webpackUrl')) {
    /**
     * Load a webpack path dynamically
     *
     * @param string|null $asset
     * @return \App\Support\Webpack|string
     * @throws Exception
     */
    function webpack(?string $asset = null)
    {
        if($asset === null) {
            return app(\App\Support\Webpack::class);
        }

        return app(\App\Support\Webpack::class)->path($asset);
    }
}
