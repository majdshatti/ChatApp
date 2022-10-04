<?php

use Illuminate\Support\Str;

/**
 * Generates a universally unique identifier (UUID)
 *
 * @return string uuid
 */
if (!function_exists("getUuid")) {
    function getUuid()
    {
        return Str::orderedUuid()->getHex();
    }
}

?>
