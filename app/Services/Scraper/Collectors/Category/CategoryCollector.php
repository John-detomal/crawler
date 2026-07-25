<?php

namespace App\Services\Scraper\Collectors\Category;

use App\Services\Scraper\Collectors\CollectorInterface;
use App\Services\Scraper\Extractor\DataExtractor;
use App\Services\Scraper\Extractor\HtmlExtractor;
use App\Services\Scraper\Collectors\Collector;
use App\Services\Scraper\Utilities\Utils;

class CategoryCollector extends Collector implements CollectorInterface
{
    public static function collect(string $html, array $config, string $baseUrl)
    {
        $htmls = Utils::extractContainerWithItemsConfig($config['content'], $html);
        $response = DataExtractor::extract($htmls, $config['options'],  $baseUrl);

        return $response;
    }

    // todo traces for matches
}
