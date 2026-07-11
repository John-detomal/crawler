<?php

namespace App\Services\Scraper\Crawler\Dto;

final class CategoryDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public ?int $parentId,

        // Site metadata
        public ?int $totalProducts = null,
        public ?int $totalPages = null,

        // Actual crawler statistics
        public int $totalProductsCrawled = 0,
        public int $totalPagesCrawled = 0,
    ) {}
}
