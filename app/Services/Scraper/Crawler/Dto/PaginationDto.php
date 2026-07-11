<?php

namespace App\Services\Scraper\Crawler\Dto;

final class PaginationDto
{
    public function __construct(
        public int $totalProducts,
        public int $totalPages,
        public int $totalProductsCrawled,
        public int $totalPagesCrawled,
        public array $products,
        public array $foundIn = [],
    ) {}
}
