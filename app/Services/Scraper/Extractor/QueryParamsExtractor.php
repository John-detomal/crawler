<?php

namespace App\Services\Scraper\Extractor;

use App\Services\Scraper\Extractor\FieldExtractor;

class QueryParamsExtractor
{
    public static function extract(string $html, array $config): array
    {
        $result = [];

        $fields = $config['fields'];
        $patterns = $config['patterns'];

        foreach ($fields as $key => $field) {
            $result[$key] = FieldExtractor::extract($html, $field, $patterns);
        }

        return $result;
    }
}
