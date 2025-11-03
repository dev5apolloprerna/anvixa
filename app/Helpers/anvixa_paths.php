<?php

use Illuminate\Support\Facades\File;

if (! function_exists('anvixa_base_path')) {
    function anvixa_base_path(string $append = ''): string
    {
        // echo 'append' . $append;
        $root = rtrim(base_path('../public_html/anviksha'), '/');

        return $append ? $root . '/' . ltrim($append, '/') : $root;
    }
}

if (! function_exists('anvixa_base_url')) {
    function anvixa_base_url(string $append = ''): string
    {
        $base = rtrim(config('app.url'), '/') . '/anviksha';
        return $append ? $base . '/' . ltrim($append, '/') : $base;
    }
}

if (! function_exists('ensure_dir')) {
    function ensure_dir(string $path, int $mode = 0775): void
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, $mode, true, true);
        }
    }
}
