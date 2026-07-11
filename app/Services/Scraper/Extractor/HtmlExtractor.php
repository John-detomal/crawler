<?php

namespace App\Services\Scraper\Extractor;

use App\Enums\Parser\ParserType;


class HtmlExtractor
{
    /**
     * @phpstan-type ConfigNode array{
     *     type: string,
     *     pattern: string,
     *     is_match_required?: bool
     * }
     *
     * @param ConfigNode|array<string, ConfigNode> $config
     */

    public static function extract(
        string $html,
        array $config,
        ?string $type = ''
    ): mixed {
        // if (isset($config['container'])) {
        //     $html = self::applycontainer($html, $config['container']);
        // }

        return self::extractHtml($html, $config, $type);
    }

    // private static function applycontainer(
    //     string $html,
    //     ?array $container,
    // ): string {

    //     if (!$container) {
    //         return $html;
    //     }

    //     $parser = ParserType::from($container['type'])->parser();

    //     return $parser
    //         ->parse($html, $container['pattern'])
    //         ->item(0)
    //         ->html() ?? '';
    // }


    private static function extractHtml(
        string $html,
        array $items,
        ?string $type = ''

    ): mixed {
        $parser = ParserType::from($items['type'])->parser();

        $parser = $parser
            ->parse($html, $items['pattern']);

        return $type ? $parser->htmlAll() : $parser->item(0)->html();
    }
}
