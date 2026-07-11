<?php

namespace App\Services\Scraper\Crawler\Dto;

final class ProductDto
{
    public function __construct(
        public string $sku,
        public string $url,
        public array $categoryIds = [],
        public array $foundIn = [],
    ) {}
}
