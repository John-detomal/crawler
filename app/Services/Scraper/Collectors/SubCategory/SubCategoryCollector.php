<?php

namespace App\Services\Scraper\Collectors\SubCategory;

use App\Services\Scraper\Collectors\Collector;
use App\Services\scraper\extractor\DataExtractor;
use App\Services\Scraper\Collectors\CollectorInterface;
use App\Services\Scraper\Utilities\Utils;

class SubCategoryCollector extends Collector implements CollectorInterface
{
    public static function collect(string $html, array $config, string $baseUrl): array
    {
        $htmls = [];
        $response = [];

        $contentsConfig = $config['contents'];
        $options = $config['options'];

        $htmls = self::resolveBlocks($html, $contentsConfig);

        if ($htmls) {
            $response = DataExtractor::extract($htmls, $options, $baseUrl);
        }

        return $response;
    }

    private static function resolveBlocks(string $html, array $contentsConfig)
    {
        $htmls = [];
        foreach ($contentsConfig as $config) {

            $htmls = Utils::extractContainerWithItemsConfig($config, $html);

            if ($htmls) {
                break;
            }
        }

        return $htmls;
    }
}
