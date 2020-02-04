<?php

if (!function_exists('serveStatic')) {
    /**
     * Serve a public asset from an s3 bucket
     *
     * @param string $filename Name of the file to load
     * @return string Url of the file on s3
     */
    function serveStatic($filename)
    {
            return 'https://'
                .config('filesystems.static_content.url').'/'
                .config('filesystems.static_content.bucket').'/'
                .config('filesystems.static_content.folder').'/'.$filename;
    }
}


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
