<?php

namespace App\Services\Scraper\Collectors;

interface CollectorInterface
{
    public static function collect(string $html, array $config, string $baseUrl);
}
