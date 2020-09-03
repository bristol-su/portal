<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Webpack
{

    /**
     * @param string $asset The path name of the asset (e.g. app.css)
     *
     * @return string
     * @throws \Exception If manifest not found
     */
    public function path(string $asset)
    {
        $manifest = static::manifest();

        if(!array_key_exists($asset, $manifest)) {
            throw new \Exception(
                sprintf('The asset %s could not be found in the manifest file, found [%s]', $asset, implode(', ', array_keys($manifest)))
            );
        }

        return $manifest[$asset];
    }

    /**
     * Load the webpack manifest
     *
     * @return array The manifest
     */
    public static function manifest(): array
    {
        $manifestPath = public_path('/manifest.json');
        if(file_exists($manifestPath)) {
            return json_decode(file_get_contents($manifestPath), true);
        }
        throw new \Exception('Webpack manifest not found');
    }

}
