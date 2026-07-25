<?php

namespace App\Services\Scraper\Extractor;

use App\Services\Scraper\Extractor\FieldExtractor;
use App\Services\Scraper\Utilities\Utils;

class DataExtractor
{
    public static function extract(
        array $htmls,
        array $options,
        string $baseUrl
    ): array {
        $results = [];
        $fields = $options['fields'];
        $patterns = $options['patterns'];

        foreach ($htmls as $html) {
            $result = [];

            foreach ($fields as $key => $field) {

                $value = FieldExtractor::extract(
                    $html,
                    $field,
                    $patterns
                );

                $result[$key] = self::transform($key, $value, $baseUrl);
            }

            $results[] = $result;
        }

        return $results;
    }

    private static function transform(
        string $key,
        mixed $value,
        string $baseUrl
    ): mixed {
        if ($value === null) {
            return null;
        }

        return match ($key) {
            'url' => Utils::fixUrl($value, $baseUrl),
            default => $value,
        };
    }
}
