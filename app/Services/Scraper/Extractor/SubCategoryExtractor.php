<?php

namespace App\Services\Scraper\Extractor;


class SubCategoryExtractor
{
    public static function extract(string $html, array $config): array
    {
        $formats = $config['fields']['formats'];
        $patterns = $config['fields']['patterns'];

        $results = [];

        foreach ($formats as $key => $field) {
            $results[$key] = FieldExtractor::extract($html, $field, $patterns);
        }

        return $results;
    }
}
