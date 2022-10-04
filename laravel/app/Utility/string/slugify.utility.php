<?php

use Illuminate\Support\Str;

/**
 * URL friendly string transformer
 *
 * @param string $value Example: HeLLo WoRld is transformed into hello-world
 *
 * @return string $value
 */
if (!function_exists("slugify")) {
    function slugify(string $value)
    {
        return Str::slug($value);
    }
}

?>
