<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Webpack
{

    /**
     * @param string $asset The path name of the asset (e.g. app.css)
     *
     *
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
//        if (! Str::startsWith($path, '/')) {
//            $path = "/{$path}";
//        }
//
//        if ($manifestDirectory && ! Str::startsWith($manifestDirectory, '/')) {
//            $manifestDirectory = "/{$manifestDirectory}";
//        }
//
//        if (file_exists(public_path($manifestDirectory.'/hot'))) {
//            $url = rtrim(file_get_contents(public_path($manifestDirectory.'/hot')));
//
//            if (Str::startsWith($url, ['http://', 'https://'])) {
//                return new HtmlString(Str::after($url, ':').$path);
//            }
//
//            return new HtmlString("//localhost:8080{$path}");
//        }
//
//        $manifestPath = public_path($manifestDirectory.'/mix-manifest.json');
    }

}
