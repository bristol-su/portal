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
