<?php

namespace App\Services\Scraper\Formatter;

class FieldFormatter
{

    public static function format(string $formats)
    {
        $pattern = "%\{([^}]*)\}\s*([^\{]*)%gm";
        preg_match_all($pattern, $formats, $matches);


        foreach ($matches as $match) {
            $indexes = $match[1];
            $separator = $match[2];
        }
    }
}
