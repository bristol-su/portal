<?php

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
