<?php

namespace App\Services\Scraper\Extractor;

use App\Services\Scraper\Extractor\QueryParamsExtractor;

class PaginationExtractor
{
    public static function extract(string $html, array $config): string
    {
        $options = $config['options'];

        if (isset($options['url_format'])) {
            return self::extractByCustomFormat($html, $options);
        }

        return self::extractByOptions($html, $options);
    }

    private static function extractByCustomFormat(string $html, array $config)
    {
        $result = QueryParamsExtractor::extract($html, $config);

        $format = $config['url_format'];

        foreach ($result as $key => $value) {
            $format = str_replace(
                '{' . $key . '}',
                $value,
                $format
            );
        }

        return $format;
    }

    private static function extractByOptions(string $html, array $options)
    {
        $queryParts = [];

        foreach ($options['fields'] as $key => $field) {
            $value = FieldExtractor::extract($html, $field, $options['patterns']);

            $queryParts[] = urlencode($key) . '=' . urlencode($value);
        }

        return implode($options['delimeter'], $queryParts);
    }
}
