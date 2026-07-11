<?php

namespace App\Services\Scraper\Crawler\Dto;

final class CrawlJobDto
{
    public function __construct(
        public string $url,
        public ?string $name = null,
        public ?int $parentId = null,
    ) {}
}
