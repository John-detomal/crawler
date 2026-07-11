<?php

namespace  App\Services\Scraper\Extractor;

use App\Enums\Parser\ParserType;
use App\Services\Scraper\Parser\Regex\RegexResult;
use App\Services\Scraper\Parser\Xpath\XpathResult;

class FieldExtractor
{
    public static function extract(
        string $html,
        array $field,
        array $patterns
    ): string {
        $template = $field['value'] ?? '';

        return preg_replace_callback(
            '/\{(\d+),(\d+)\}/',
            function ($matches) use ($html, $patterns) {
                $patternIndex = (int) $matches[1] - 1;
                $groupIndex = (int) $matches[2];

                if (!isset($patterns[$patternIndex])) {
                    return '';
                }

                $pattern = $patterns[$patternIndex];

                $parser = ParserType::from($pattern['type'])->parser();
                $result = $parser->parse($html, $pattern['pattern']);

                return self::extractValue($result, $groupIndex);
            },
            $template
        );
    }


    private static function extractValue(RegexResult | XpathResult $result, int $group): string
    {
        if (!$result->item(0)) {
            return '';
        }

        return $result->item(0)->text($group);
    }
}
